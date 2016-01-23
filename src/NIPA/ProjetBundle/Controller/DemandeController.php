<?php

namespace NIPA\ProjetBundle\Controller;

use NIPA\ProjetBundle\Form\Type\DemandeFormType;

use NIPA\ProjetBundle\Entity\Demande;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DemandeController extends Controller
{
	
    public function indexAction()
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/
        
        $droit = 0;
        $user = $this->getUser();
    
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
                {
                    $droit++;           
                }
            }
        }
        
        if ($droit == 0) {
            //return $this->render($this->getRequest()->server->get('HTTP_REFERER'), array('droit' => $droit));
            $droit = "denied";
            $referer = $this->getRequest()->server->get('HTTP_REFERER');
            return $this->redirect($referer."?droit=".$droit);  
        }

        /***************DATA TREE*******************/
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });              
        /************************************/
        $demande = new Demande(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new DemandeFormType(), $demande); // On bind l'objet à notre formulaire 
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();         
        /*************************************************/     
       
        //return array();
        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array('user' => $user, 'form' => $form->createView(), 'demande' => $demande, 'listDemande' => $listDemande,'choices' => $choices)); // On passe à Twig l'objet form et notre objet
    
    } 

    
    /**
    *  ADD a Demande
    * 
    */
    public function addDemandeAction()    
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/        
        
        $droit = 0;
        $user = $this->getUser();
    
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
                {
                    $droit++;           
                }
            }
        }
        
        if ($droit == 0) {
            //return $this->render($this->getRequest()->server->get('HTTP_REFERER'), array('droit' => $droit));
            $droit = "denied";
            $referer = $this->getRequest()->server->get('HTTP_REFERER');
            return $this->redirect($referer."?droit=".$droit);  
        }
      
        $request = $this->get('request'); // On récupère l'objet request via le service container
        
        /***************DATA TREE*******************/
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });         
        
        /************************************/
        $demande = new Demande(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new DemandeFormType(), $demande); // On bind l'objet à notre formulaire 
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();         
        /*************************************************/       
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {                                   
   
                /*******************CALCUL de la référence*********************/
                // Récupération de la référence du portefeuille selectionnée (liste déroulante)
                $referencePortefeuille=$this->getRequest()->request->get('referencePortefeuille');
                // Conversion de PF-15-01 --> PF1501
                $refPortefeuille = str_replace('-', '', $referencePortefeuille);

                \Doctrine\Common\Util\Debug::dump($refPortefeuille);                
            
                // On requete pour rechercher (LIKE) les références Demande similaire à celle du Portefeuille
                $refs = $this->getDoctrine()->getManager()
                        ->createQuery('Select d.referenceDemande from NIPAProjetBundle:Demande d Where d.referenceDemande LIKE :ipp')
                        ->setParameter('ipp', '%'.$refPortefeuille.'%')
                        ->getResult();        
                
            \Doctrine\Common\Util\Debug::dump($refs);
                
                $indice = 0;
                // On boucle pour chercher la ref xxxx-001 -> 001 
                for($i=0; $i<sizeof($refs); $i++)
                {
                    if(substr($refs[$i]["referenceDemande"], -3)>$indice)
                    {
                        // On retourne indice (string) de la ref la plus haute
                        $indice = substr($refs[$i]["referenceDemande"], -3);
                    }
                }
                         
                \Doctrine\Common\Util\Debug::dump($indice);
                
                //Mettre au bon format: pour les exceptions type 100 ou 10, 20, 30...
                if(substr($indice, -2) == '00')
                {
                    $pre = substr($indice, 0, 1);
                    $indice = str_replace('0', '', $pre).substr($indice,-2);                  
                }
                else
                {
                    $pre = substr($indice, 0, 2);
                    $indice = str_replace('0', '', $pre).substr($indice,-1, 1);
                }
                
                \Doctrine\Common\Util\Debug::dump($indice);

                if(strlen($indice) == 1)
                {
                    $number_ref = $indice + 1;
                    $number_ref = '00'.$number_ref;
                }
                else if(strlen($indice) == 2)
                {
                    $number_ref = $indice + 1;
                    $number_ref = '0'.$number_ref;        
                }
                else
                {
                    $number_ref = $indice + 1;   
                }
                
                $reference = $refPortefeuille.'-'.$number_ref;
                \Doctrine\Common\Util\Debug::dump($reference);

                $demande->setReferenceDemande($reference);
                /**************************************************************/
                
               //if ($form->isValid()) { // Si le formulaire est valide              
                $em = $this->getDoctrine()->getEntityManager();
                    
                    $this->get('nipa_demande.demande_manager')->saveDemande($demande); // On utilise notre Manager pour gérer la sauvegarde de l'objet
                       
                    // On add la demande au portfeuille selectionné
                    $portefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadPortefeuille($referencePortefeuille);
                    $portefeuille->addDemandes($demande);

                    $em->flush();                    
                            
                    $this->get('session')->getFlashBag()->set('success',
                    $this->get('translator')->trans('Demande créée')
                    );

                     // On redirige vers la page de modification de la demande
                     return new RedirectResponse($this->generateUrl('demande_edit', array(
                       'reference' => $demande->getReferenceDemande()
                    )));
                     
                //}   
        }

        //return array();
        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array('user' => $user, 'form' => $form->createView(), 'demande' => $demande, 'listDemande' => $listDemande,'choices' => $choices)); // On passe à Twig l'objet form et notre objet

    }    
    
    
   /**
    *  EDIT a demande
    * 
    */
    public function editDemandeAction(Request $request, $reference)    
    {

        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/
        
        $droit = 0;
        $user = $this->getUser();
            
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
                {
                    $droit++;           
                }
            }
        }
        
        if ($droit == 0) {
            //return $this->render($this->getRequest()->server->get('HTTP_REFERER'), array('droit' => $droit));
            $droit = "denied";
            $referer = $this->getRequest()->server->get('HTTP_REFERER');
            return $this->redirect($referer."?droit=".$droit);  
        }

        
        // On vérifie que le portefeuille existe
        if(!$demande = $this->get('nipa_demande.demande_manager')->loadDemande($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This demande does not exist.')
            );
        }
    
        /***************DATA TREE*******************/
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });         
                  
        /************************************/
        
        $form = $this->createForm(new DemandeFormType(), $demande);
         
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices(); 
        
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {                
        //if('POST' == $request->getMethod()) { // Si on a posté le formulaire
            //$form->submit($request->request->get($form->getName()));                       
           
           //if ($form->isValid()) { // Si le formulaire est valide
                
                $demande->setReferenceDemande($reference);
                        
                $this->get('nipa_demande.demande_manager')->saveDemande($demande); // On utilise notre Manager pour gérer la sauvegarde de l'objet
                
                $this->get('session')->getFlashBag()->set('success',
                $this->get('translator')->trans('Demande mise à jour')
                );
                
                // On redirige vers la page de modification du portefeuille
                return new RedirectResponse($this->generateUrl('demande_edit', array(
                  'reference' => $demande->getReferenceDemande()
               )));
            //}   
        
        }
        //return array();
        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array('user' => $user, 'form' => $form->createView(), 'demande' => $demande, 'listDemande' => $listDemande,'choices' => $choices)); // On passe à Twig l'objet form et notre objet

    }      
    
}