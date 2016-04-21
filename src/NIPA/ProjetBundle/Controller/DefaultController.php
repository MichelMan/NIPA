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
        $results = $conn->query('SELECT Port.Reference_Portefeuille, Port.Nom, PortA.Valeur, PortEnv.Nom, PortStatut.Nom FROM Portefeuille Port INNER JOIN Portefeuille_annee PortA ON Port.portefeuille_annee_id = PortA.id INNER JOIN Portefeuille_Enveloppe PortEnv ON Port.portefeuille_enveloppe_id = PortEnv.id INNER JOIN Portefeuille_Statut PortStatut ON Port.portefeuille_statut_id = PortStatut.id');

        $response = new StreamedResponse();
        $response->setCallback(function() use($results){

            $handle = fopen('php://output', 'w+');
            // Nom des colonnes du CSV 
            fputcsv($handle, array('Reference_Portefeuille',
                                   'Nom',
                                   'Annee',
                                   'Env',
                                   'Statut',
                  ),';');

            //Champs
            while($row = $results->fetch()) 
             {

                  fputcsv($handle,array($row['Reference_Portefeuille'],
                                        $row['Nom'],
                                        $row['Valeur'],
                                        $row['Nom'],
                                        $row['Nom'],
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
        
        //Connexion à la base de données avec le service database_connection
        $conn = $this->get('database_connection');

        //Requête Portefeuille
        $results = $conn->query('SELECT Port.Reference_Portefeuille, Port.Nom, PortA.Valeur AS Annee, PortEnv.Nom AS Enveloppe, PortStatut.Nom AS Statut FROM Portefeuille Port INNER JOIN Portefeuille_annee PortA ON Port.portefeuille_annee_id = PortA.id INNER JOIN Portefeuille_Enveloppe PortEnv ON Port.portefeuille_enveloppe_id = PortEnv.id INNER JOIN Portefeuille_Statut PortStatut ON Port.portefeuille_statut_id = PortStatut.id');
        
        //Requête Demande
        $results2 = $conn->query('SELECT Dem.Reference_Demande, Dem.Nom, Demande_Priorite.Nom AS Priorite, Dem.Type_Enveloppe, Dem.Commentaires, Dem.Date_MEP, Dem.TTD_Souhaite, Dem.TTD_Souhaite_Revise, Dem.TTD_Projets, Dem.TTD_Projets_Revises, Dem.Nb_Lots, Demande_Direction.Nom AS Direction, Demande_Entite_Metier.Nom AS EntiteMetier, Demande_Offres.Nom AS Offre, Demande_Type_Projet.Nom AS TypeProjet, Demande_Statut.Nom AS Statut, Demande_Porteur_Metier.Nom AS PorteurMetier, Demande_Interlocuteur_MOA.Nom AS InterlocuteurMOA, Demande_SDM.Nom AS SDM, Dem.REX, Dem.Date_Cloture FROM Demande Dem INNER JOIN Demande_Priorite ON Dem.demande_priorite_id = Demande_Priorite.id INNER JOIN Demande_Direction ON Dem.demande_direction_id = Demande_Direction.id INNER JOIN Demande_Entite_Metier ON Dem.demande_entite_metier_id = Demande_Entite_Metier.id INNER JOIN Demande_Offres ON Dem.demande_offres_id = Demande_Offres.id INNER JOIN Demande_Type_Projet ON Dem.demande_type_projet_id = Demande_Type_Projet.id INNER JOIN Demande_Statut ON Dem.demande_statut_id = Demande_Statut.id INNER JOIN Demande_Porteur_Metier ON Dem.demande_porteur_metier_id = Demande_Porteur_Metier.id INNER JOIN Demande_Interlocuteur_MOA ON Dem.demande_interlocuteur_MOA_id = Demande_Interlocuteur_MOA.id INNER JOIN Demande_SDM ON Dem.demande_SDM_id = Demande_SDM.id');

        //Requête Projet
        $results3 = $conn->query('SELECT Pro.Reference_Projet, Pro.titre, Pro.titreLot, Pro.codeOGP, Pro.enveloppe, Pro.priorite, Pro.direction, Pro.entiteMetier, Pro.offres, Pro.typeProjet, Pro.divers, Pro.interlocuteurMOA, Pro.porteurMetier, Pro.SDM, Pro.devSI, Pro.devRZO, Pro.indicateur, Pro.phaseProjet, Pro.annuler, Pro.suspendre, Pro.commentaires, Pro.alerte, Pro.escalade, Pro.lotissement, Pro.phaseProjetEnCours, Pro.BudgetEnCours, Pro.dateMEP FROM Projet Pro');        
        
        
        /*********************************/
        
        // ask the service for a Excel5
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("MMAN")
           ->setLastModifiedBy("Michel MAN")
           ->setTitle("Export Data NIPA")
           ->setSubject("Export Data NIPA ALL")
           ->setDescription("Data of Portefeuille, Demande and Projet.");
        $phpExcelObject->getActiveSheet()->setTitle('Portefeuille');

        // EN-TETE
        $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A1', 'Reference')
           ->setCellValue('B1', 'Nom')        
           ->setCellValue('C1', 'Enveloppe')    
           ->setCellValue('D1', 'Annee') 
           ->setCellValue('E1', 'Statut');    
           
        $F = $phpExcelObject->setActiveSheetIndex(0);
        $Line=2;        
        
        //while($row = $result->fetch_assoc()){//extract each record
        while($row = $results->fetch()) { 
            //\Doctrine\Common\Util\Debug::dump($row);
            $F->setCellValue('A'.$Line, $row['Reference_Portefeuille']);
            $F->setCellValue('B'.$Line, $row['Nom']);
            $F->setCellValue('C'.$Line, $row['Enveloppe']);
            $F->setCellValue('D'.$Line, $row['Annee']);
            $F->setCellValue('E'.$Line, $row['Statut']); //write in the sheet
            ++$Line;
        }
        
        
        // Add new sheet Demande
        $objWorkSheet = $phpExcelObject->createSheet(1); //Setting index when creating   
        $objWorkSheet->setTitle('Demande');
        
       // EN-TETE
        $phpExcelObject->setActiveSheetIndex(1)
           ->setCellValue('A1', 'Reference')
           ->setCellValue('B1', 'Nom')        
           ->setCellValue('C1', 'Priorite')    
           ->setCellValue('D1', 'Type_Enveloppe') 
           ->setCellValue('E1', 'Commentaires') 
           ->setCellValue('F1', 'Date_MEP') 
           ->setCellValue('G1', 'TTD_Souhaite') 
           ->setCellValue('H1', 'TTD_Souhaite_Revise') 
           ->setCellValue('I1', 'TTD_Projets') 
           ->setCellValue('J1', 'TTD_Projets_Revises') 
           ->setCellValue('K1', 'Nb_Lots') 
           ->setCellValue('L1', 'Direction') 
           ->setCellValue('M1', 'Entite_Metier') 
           ->setCellValue('N1', 'Offres') 
           ->setCellValue('O1', 'Type_Projet') 
           ->setCellValue('P1', 'Statut')   
           ->setCellValue('Q1', 'Porteur_Metier')  
           ->setCellValue('R1', 'Interlocuteur_MOA')   
           ->setCellValue('S1', 'SDM')   
           ->setCellValue('T1', 'REX')
           ->setCellValue('U1', 'Date_Cloture');   
        
        $F = $phpExcelObject->setActiveSheetIndex(1);
        $Line=2;     
        
        //while($row = $result->fetch_assoc()){//extract each record
        while($row = $results2->fetch()) { 
            $F->setCellValue('A'.$Line, $row['Reference_Demande']);
            $F->setCellValue('B'.$Line, $row['Nom']);
            $F->setCellValue('C'.$Line, $row['Priorite']);
            $F->setCellValue('D'.$Line, $row['Type_Enveloppe']);
            $F->setCellValue('E'.$Line, $row['Commentaires']); 
            $F->setCellValue('F'.$Line, $row['Date_MEP']); 
            $F->setCellValue('G'.$Line, $row['TTD_Souhaite']); 
            $F->setCellValue('H'.$Line, $row['TTD_Souhaite_Revise']); 
            $F->setCellValue('I'.$Line, $row['TTD_Projets']); 
            $F->setCellValue('J'.$Line, $row['TTD_Projets_Revises']); 
            $F->setCellValue('K'.$Line, $row['Nb_Lots']); 
            $F->setCellValue('L'.$Line, $row['Direction']); 
            $F->setCellValue('M'.$Line, $row['EntiteMetier']); 
            $F->setCellValue('N'.$Line, $row['Offre']); 
            $F->setCellValue('O'.$Line, $row['TypeProjet']); 
            $F->setCellValue('P'.$Line, $row['Statut']); 
            $F->setCellValue('Q'.$Line, $row['PorteurMetier']); 
            $F->setCellValue('R'.$Line, $row['InterlocuteurMOA']); 
            $F->setCellValue('S'.$Line, $row['SDM']); 
            $F->setCellValue('T'.$Line, $row['REX']); 
            $F->setCellValue('U'.$Line, $row['Date_Cloture']); 

            ++$Line;
        }        
        
        
        // Add new sheet Projet
        $objWorkSheet2 = $phpExcelObject->createSheet(2); //Setting index when creating   
        $objWorkSheet2->setTitle('Projet');
        
       // EN-TETE
        $phpExcelObject->setActiveSheetIndex(2)
           ->setCellValue('A1', 'Reference_Projet')
           ->setCellValue('B1', 'Titre')        
           ->setCellValue('C1', 'Titre_Lot')    
           ->setCellValue('D1', 'Code_OGP') 
           ->setCellValue('E1', 'Enveloppe') 
           ->setCellValue('F1', 'Priorite') 
           ->setCellValue('G1', 'Direction') 
           ->setCellValue('H1', 'Entite_Metier') 
           ->setCellValue('I1', 'Offres') 
           ->setCellValue('J1', 'Type_Projet') 
           ->setCellValue('K1', 'Divers') 
           ->setCellValue('L1', 'Interlocuteur_MOA') 
           ->setCellValue('M1', 'Porteur_Metier') 
           ->setCellValue('N1', 'SDM') 
           ->setCellValue('O1', 'Dev_SI') 
           ->setCellValue('P1', 'Dev_RZO')   
           ->setCellValue('Q1', 'Indicateur')  
           ->setCellValue('R1', 'Phase_Projet')   
           ->setCellValue('S1', 'Annuler')   
           ->setCellValue('T1', 'Suspendre')
           ->setCellValue('U1', 'Commentaires')
           ->setCellValue('V1', 'Alerte')
           ->setCellValue('W1', 'Escalade')
           ->setCellValue('X1', 'Lotissement')
           ->setCellValue('Y1', 'Phase_Projet_En_Cours')
           ->setCellValue('Z1', 'Budget_En_Cours')
           ->setCellValue('AA1', 'Date_MEP')
                ;   
        
        $F = $phpExcelObject->setActiveSheetIndex(2);
        $Line=2;     
        
        //while($row = $result->fetch_assoc()){//extract each record
        while($row = $results3->fetch()) { 
            
            $projet = $this->get('nipa_projet.projet_manager')->loadProjet($row['Reference_Projet']);            
            
            //return array() List Etapes ALL
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
            $listProjetPhases = $repository->findAll();     
            //On trie la liste
            usort($listProjetPhases, function ($a, $b) {
                return strnatcmp($a->getReference(), $b->getReference());
            });
        
            //return array() List Livrables
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetLivrable');
            $listProjetLivrable = $repository->findAll();  
            //On trie la liste 
            usort($listProjetLivrable, function ($a, $b) {
                return strnatcmp($a->getReference(), $b->getReference());
            });

            //return array() List Jalons Date
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetJalonDate');
            $listProjetJalonDate = $repository->findAll();  
            //On trie la liste 
            usort($listProjetJalonDate, function ($a, $b) {
                return strnatcmp($a->getReference(), $b->getReference());
            });

            //return array() List Instances
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
            $listProjetInstance = $repository->findByType("Projet");  
            //On trie la liste 
            usort($listProjetInstance, function ($a, $b) {
                return strnatcmp($a->getReference(), $b->getReference());
            }); 

            /**********************/            
            
            //return array() List ListeInstance
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeInstance');
            $listProjetListeInstance = $repository->findByProjet($projet);  
            //On trie la liste 
            usort($listProjetListeInstance, function($a, $b) {
              return ($a->getDatePrev() > $b->getDatePrev()) ? -1 : 1;
            });     
            
            //return array() List ListeJalonDate En Cadrage
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeJalonDate');
            $listProjetListeJalonDateEnCadrage = $repository->getJalonDateProjetEnCadrage($projet);     

            //return array() List ListeJalonDate En Conception
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeJalonDate');
            $listProjetListeJalonDateEnConception = $repository->getJalonDateProjetEnConception($projet);    

            //return array() List ListeJalonDate En Realisation
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeJalonDate');
            $listProjetListeJalonDateEnRealisation = $repository->getJalonDateProjetEnRealisation($projet);    

            //return array() List ListeLivrable En Cadrage
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeLivrable');
            $listProjetListeLivrableEnCadrage = $repository->getLivrableProjetEnCadrage($projet);     

            //return array() List ListeLivrable En Conception
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeLivrable');
            $listProjetListeLivrableEnConception = $repository->getLivrableProjetEnConception($projet); 

            //return array() List ListeLivrable En Realisation
            $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeLivrable');
            $listProjetListeLivrableEnRealisation = $repository->getLivrableProjetEnRealisation($projet);            

            /****/
            
            $F->setCellValue('A'.$Line, $row['Reference_Projet']);
            $F->setCellValue('B'.$Line, $row['titre']);
            $F->setCellValue('C'.$Line, $row['titreLot']);
            $F->setCellValue('D'.$Line, $row['codeOGP']);
            $F->setCellValue('E'.$Line, $row['enveloppe']); 
            $F->setCellValue('F'.$Line, $row['priorite']); 
            $F->setCellValue('G'.$Line, $row['direction']); 
            $F->setCellValue('H'.$Line, $row['entiteMetier']); 
            $F->setCellValue('I'.$Line, $row['offres']); 
            $F->setCellValue('J'.$Line, $row['typeProjet']); 
            $F->setCellValue('K'.$Line, $row['divers']); 
            $F->setCellValue('L'.$Line, $row['interlocuteurMOA']); 
            $F->setCellValue('M'.$Line, $row['porteurMetier']); 
            $F->setCellValue('N'.$Line, $row['SDM']); 
            $F->setCellValue('O'.$Line, $row['devSI']); 
            $F->setCellValue('P'.$Line, $row['devRZO']); 
            $F->setCellValue('Q'.$Line, $row['indicateur']); 
            $F->setCellValue('R'.$Line, $row['phaseProjet']); 
            $F->setCellValue('S'.$Line, $row['annuler']); 
            $F->setCellValue('T'.$Line, $row['suspendre']); 
            $F->setCellValue('U'.$Line, $row['commentaires']); 
            $F->setCellValue('V'.$Line, $row['alerte']); 
            $F->setCellValue('W'.$Line, $row['escalade']); 
            $F->setCellValue('X'.$Line, $row['lotissement']); 
            $F->setCellValue('Y'.$Line, $row['phaseProjetEnCours']); 
            $F->setCellValue('Z'.$Line, $row['BudgetEnCours']); 
            
            if($row['dateMEP'] != "")
            {
                $format = date('d-m-Y', strtotime($row['dateMEP'])); 
                $date = str_replace('-', '/', $format);
                $F->setCellValue('AA'.$Line, $date); 
            }
            

            $Col=28;
            foreach ($listProjetPhases as $phase)
            {
                foreach($listProjetJalonDate as $jalonDate)
                {
                    if($jalonDate->getRefPhase()->getNom() == $phase->getNom())
                    {
                        $jd = $jalonDate->getNom();
                        $F->setCellValueByColumnAndRow($Col++, 1, "DatePrev ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "DateRev ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "Validation ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "Remarques ".$jd);
                    }
                }
                
                foreach($listProjetLivrable as $livrable)
                {
                    if($livrable->getRefPhase()->getNom() == $phase->getNom())
                    {
                        $jd = $livrable->getNom();
                        $F->setCellValueByColumnAndRow($Col++, 1, "DatePrev ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "DateRev ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "Validation ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "Remarques ".$jd);
                    }
                }
                
                foreach($listProjetInstance as $instance)
                {
                    if($instance->getRefPhase()->getNom() == $phase->getNom())
                    {
                        $jd = $instance->getNom();
                        $F->setCellValueByColumnAndRow($Col++, 1, "Date ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "Validation ".$jd);
                        $F->setCellValueByColumnAndRow($Col++, 1, "Remarques ".$jd);
                    }
                }

            }
            
            //$F->setCellValueByColumnAndRow(28, $Line, $projet->getReferenceProjet()); 
            /*\Doctrine\Common\Util\Debug::dump($listProjetListeJalonDateEnCadrage);
            \Doctrine\Common\Util\Debug::dump($listProjetListeJalonDateEnConception);
            \Doctrine\Common\Util\Debug::dump($listProjetListeJalonDateEnRealisation);
            \Doctrine\Common\Util\Debug::dump($listProjetListeInstance);
            \Doctrine\Common\Util\Debug::dump($listProjetListeLivrableEnCadrage);
            \Doctrine\Common\Util\Debug::dump($listProjetListeLivrableEnConception);
            \Doctrine\Common\Util\Debug::dump($listtoto);*/
            /****/
            /*
            $Col=29;
            foreach ($listProjetListeJalonDateEnCadrage as $JalonDateEnCadrage)
            {
                $jalonDate = $JalonDateEnCadrage->getJalonDate()->getNom();
                $F->setCellValueByColumnAndRow($Col, 1, "DatePrev ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+1, 1, "DateRev ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+2, 1, "Validation ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+3, 1, "Remarques ".$jalonDate);
                
                if($JalonDateEnCadrage->getDatePrev() != "")
                {
                    $result = $JalonDateEnCadrage->getDatePrev()->format('Y-m-d');
                    $format = date('d-m-Y', strtotime($result)); 
                    $date = str_replace('-', '/', $format);
                    $F->setCellValueByColumnAndRow($Col, $Line, $date);
                }  
                else
                {
                    $F->setCellValueByColumnAndRow($Col, $Line, "");
                } 
                if($JalonDateEnCadrage->getDateRev() != "")
                {
                    $result = $JalonDateEnCadrage->getDateRev()->format('Y-m-d');
                    $format = date('d-m-Y', strtotime($result)); 
                    $date = str_replace('-', '/', $format);
                    $F->setCellValueByColumnAndRow($Col+1, $Line, $date);
                }  
                else
                {
                    $F->setCellValueByColumnAndRow($Col+1, $Line, "");
                } 
                $F->setCellValueByColumnAndRow($Col+2, $Line, $JalonDateEnCadrage->getValidationEffective());
                $F->setCellValueByColumnAndRow($Col+3, $Line, $JalonDateEnCadrage->getRemarques());   
                $Col++;
            }
            foreach ($listProjetListeJalonDateEnConception as $JalonDateEnConception)
            {
                $jalonDate = $JalonDateEnConception->getJalonDate()->getNom();
                $F->setCellValueByColumnAndRow($Col, 1, "DatePrev ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+1, 1, "DateRev ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+2, 1, "Validation ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+3, 1, "Remarques ".$jalonDate);  
                
                if($JalonDateEnConception->getDatePrev() != "")
                {
                    $result = $JalonDateEnConception->getDatePrev()->format('Y-m-d');
                    $format = date('d-m-Y', strtotime($result)); 
                    $date = str_replace('-', '/', $format);
                    $F->setCellValueByColumnAndRow($Col, $Line, $date);
                }  
                else
                {
                    $F->setCellValueByColumnAndRow($Col, $Line, "");
                } 
                if($JalonDateEnConception->getDateRev() != "")
                {
                    $result = $JalonDateEnConception->getDateRev()->format('Y-m-d');
                    $format = date('d-m-Y', strtotime($result)); 
                    $date = str_replace('-', '/', $format);
                    $F->setCellValueByColumnAndRow($Col+1, $Line, $date);
                }  
                else
                {
                    $F->setCellValueByColumnAndRow($Col+1, $Line, "");
                }                 
                $F->setCellValueByColumnAndRow($Col+2, $Line, $JalonDateEnConception->getValidationEffective());
                $F->setCellValueByColumnAndRow($Col+3, $Line, $JalonDateEnConception->getRemarques());   
                $Col++;
            }            
            foreach ($listProjetListeJalonDateEnRealisation as $JalonDateEnRealisation)
            {
                $jalonDate = $JalonDateEnRealisation->getJalonDate()->getNom();
                $F->setCellValueByColumnAndRow($Col, 1, "DatePrev ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+1, 1, "DateRev ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+2, 1, "Validation ".$jalonDate);
                $F->setCellValueByColumnAndRow($Col+3, 1, "Remarques ".$jalonDate);  
                
                if($JalonDateEnRealisation->getDatePrev() != "")
                {
                    $result = $JalonDateEnRealisation->getDatePrev()->format('Y-m-d');
                    $format = date('d-m-Y', strtotime($result)); 
                    $date = str_replace('-', '/', $format);
                    $F->setCellValueByColumnAndRow($Col, $Line, $date);
                }  
                else
                {
                    $F->setCellValueByColumnAndRow($Col, $Line, "");
                }
                if($JalonDateEnRealisation->getDateRev() != "")
                {
                    $result = $JalonDateEnRealisation->getDateRev()->format('Y-m-d');
                    $format = date('d-m-Y', strtotime($result));
                    $date = str_replace('-', '/', $format);
                    $F->setCellValueByColumnAndRow($Col+1, $Line, $date);
                }
                else
                {
                    $F->setCellValueByColumnAndRow($Col+1, $Line, "");
                }
                $F->setCellValueByColumnAndRow($Col+2, $Line, $JalonDateEnRealisation->getValidationEffective());
                $F->setCellValueByColumnAndRow($Col+3, $Line, $JalonDateEnRealisation->getRemarques());   
                $Col++;
            }  */
            
            ++$Line;
        }        
        
        
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
