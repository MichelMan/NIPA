<?php

namespace NIPA\ProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NIPAProjetBundle:Default:index.html.twig', array('name' => $name));
    }
    
    
    /**
    *  EXPORT DATA
    * 
    */
    public function generateCsvAction(){

        //Connexion à la base de données avec le service database_connection
        $conn = $this->get('database_connection');

        //Requête
        $results = $conn->query('SELECT Port.Reference_Portefeuille, Port.Nom, PortA.Valeur, Dem.Reference_Demande, Pro.Reference_Projet FROM Portefeuille Port INNER JOIN Portefeuille_annee PortA ON Port.portefeuille_annee_id = PortA.id, Demande Dem INNER JOIN Projet Pro ON Dem.id = Pro.demande_id, portefeuilles_demandes P_D WHERE Dem.id = P_D. demande_id AND Port.id = P_D.portefeuille_id');

        $response = new StreamedResponse();
        $response->setCallback(function() use($results){

            $handle = fopen('php://output', 'w+');
            // Nom des colonnes du CSV 
            fputcsv($handle, array('Reference_Portefeuille',
                                   'Nom',
                                   'Annee',
                                   'Reference_Demande',
                                   'Reference_Projet',
                  ),';');

            //Champs
            while($row = $results->fetch()) 
             {

                  fputcsv($handle,array($row['Reference_Portefeuille'],
                                        $row['Nom'],
                                        $row['Valeur'],
                                        $row['Reference_Demande'],
                                        $row['Reference_Projet'],
                         ),';');

             }

          fclose($handle);
        });
    
         $response->setStatusCode(200);
         $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
         $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

         return $response;                             

    }
     
    
    /**
    *  EXPORT DATA
    * 
    */
    public function generateCsv2Action($name)
    {
        // ask the service for a Excel5
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("MMAN")
           ->setLastModifiedBy("Michel MAN")
           ->setTitle("Export Data NIPA")
           ->setSubject("Export Data NIPA ALL")
           ->setDescription("Data of Portefeuille, Demande and Projet.");
        $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A1', 'Hello')
           ->setCellValue('B2', 'world!');
        $phpExcelObject->getActiveSheet()->setTitle('Portefeuille');
        // Add new sheet Demande
        $objWorkSheet = $phpExcelObject->createSheet(1); //Setting index when creating   
        $objWorkSheet->setTitle('Demande');
        $phpExcelObject->setActiveSheetIndex(1)
           ->setCellValue('A1', 'Hello')
           ->setCellValue('B2', 'mama!');
        
        // Add new sheet Projet
        $objWorkSheet2 = $phpExcelObject->createSheet(2); //Setting index when creating   
        $objWorkSheet2->setTitle('Projet');
        $phpExcelObject->setActiveSheetIndex(2)
           ->setCellValue('A1', 'TOTO')
           ->setCellValue('B2', 'TITI!');        
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $name.'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }    
    
}
