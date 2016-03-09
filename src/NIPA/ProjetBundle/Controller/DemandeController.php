<?php

namespace NIPA\ProjetBundle\Controller;

use NIPA\ProjetBundle\Form\Type\DemandeFormType;
use NIPA\ProjetBundle\Form\Type\SelectPortefeuilleModalType;
use NIPA\ProjetBundle\Form\Type\DemandeBudgetFormType;
use NIPA\ProjetBundle\Form\Type\DemandeListeInstanceFormType;

use NIPA\ProjetBundle\Entity\Demande;
use NIPA\ProjetBundle\Entity\DemandeBudget;
use NIPA\ProjetBundle\Entity\DemandeListeInstance;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


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
                if(($groupe->getPermission()->getCMSDemande() == 1) || ($groupe->getPermission()->getLDemande() == 1)) // Si oui on test les droits d'accès
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
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });   
        
        /************************************/
        $demande = new Demande(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new DemandeFormType(), $demande); // On bind l'objet à notre formulaire 
        
        $formFiltres = $this->get('form.factory')->create(new DemandeFormType(), $demande); // Filtres Form
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();         
        /*************************************************/     
       
        
        //return array();
        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(),
            'formFiltres' => $formFiltres->createView(),
            'demande' => $demande, 
            'listDemande' => $listDemande,
            'choices' => $choices,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut)); 
    
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
                if(($groupe->getPermission()->getCMSDemande() == 1) || ($groupe->getPermission()->getLDemande() == 1)) // Si oui on test les droits d'accès
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
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });   
        
        /************************************/
        $demande = new Demande(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new DemandeFormType(), $demande); // On bind l'objet à notre formulaire 
        
        $formFiltres = $this->get('form.factory')->create(new DemandeFormType(), $demande); // Filtres Form

        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();         

        /***************Formulaire select Portefeuilles****************/
        $portefeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
        $portefeuilles = $portefeuilleManager->loadAllPortefeuille(); // on accède aux service et on récupère les méthodes dans portefeuilleManager
        
        $formModal = $this->get('form.factory')->create(new SelectPortefeuilleModalType(), $portefeuilles);        
        
        $options2 = $formModal->get('portefeuille')->getConfig()->getOptions();
        $choices2 = $options2['choice_list']->getChoices();            
        /***************************************************************/
        // DemandeBudget Form
        $DemandeBudget = new DemandeBudget();  
        $formBudget = $this->createForm(new DemandeBudgetFormType(), $DemandeBudget);
        
        //On récupère toutes les tuples du budget actuel
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findBy(array('demande' => $demande)); // Critere

        // On trie les budgets dans l'ordre CHRONO par date
        usort($listDemandeBudget, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /***************************************************************/
        
        // DemandeInstance Form
        $DemandeListeInstance = new DemandeListeInstance();  
        $formInstance = $this->createForm(new DemandeListeInstanceFormType(), $DemandeListeInstance);
        
        //On récupère liste des tuples instances de la Demande
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
        $listDemandeInstance = $repository->findBy(array('demande' => $demande)); // Critere
        
        // On trie les instances dans l'ordre CHRONO par date
        usort($listDemandeInstance, function($a, $b) {
          return ($a->getDatePrev() < $b->getDatePrev()) ? -1 : 1;
        });        
        /***************************************************************/   
        
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {                                   
   
                /*******************CALCUL de la référence*********************/
                // Récupération de la référence du portefeuille selectionnée (liste déroulante)
                $referencePortefeuille=$this->getRequest()->request->get('referencePortefeuille');
                // Conversion de PF-15-01 --> PF1501
                $refPortefeuille = str_replace('-', '', $referencePortefeuille);

                //\Doctrine\Common\Util\Debug::dump($refPortefeuille);                
            
                // On requete pour rechercher (LIKE) les références Demande similaire à celle du Portefeuille
                $refs = $this->getDoctrine()->getManager()
                        ->createQuery('Select d.referenceDemande from NIPAProjetBundle:Demande d Where d.referenceDemande LIKE :ipp')
                        ->setParameter('ipp', '%'.$refPortefeuille.'%')
                        ->getResult();        
                
                //\Doctrine\Common\Util\Debug::dump($refs);
                
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
                         
                //\Doctrine\Common\Util\Debug::dump($indice);
                
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
                
                //\Doctrine\Common\Util\Debug::dump($indice);

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
                //\Doctrine\Common\Util\Debug::dump($reference);

                $demande->setReferenceDemande($reference);
                /**************************************************************/
                
               //if ($form->isValid()) { // Si le formulaire est valide              
                $em = $this->getDoctrine()->getEntityManager();
                    
                    // On add la demande au portfeuille selectionné
                    $portefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadPortefeuille($referencePortefeuille);
                    $portefeuille->addDemandes($demande);

                    // On met a jour le typeEnveloppe
                    $demande->setTypeEnveloppe($portefeuille->getPortefeuilleEnveloppe()->getNom());
                    
                    $this->get('nipa_demande.demande_manager')->saveDemande($demande); // On utilise notre Manager pour gérer la sauvegarde de l'objet
                    
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
        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(), 
            'formFiltres' => $formFiltres->createView(),
            'formModal' => $formModal->createView(), 
            'formInstance' => $formInstance->createView(), 
            'formBudget' => $formBudget->createView(), 
            'demande' => $demande,
            'listDemande' => $listDemande,
            'choices' => $choices, 
            'choices2' => $choices2, 
            'listDemandeBudget' => $listDemandeBudget, 
            'listDemandeInstance' => $listDemandeInstance,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut)); 

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
                if(($groupe->getPermission()->getCMSDemande() == 1) || ($groupe->getPermission()->getLDemande() == 1)) // Si oui on test les droits d'accès
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

        
        // On vérifie que l'objet existe
        if(!$demande = $this->get('nipa_demande.demande_manager')->loadDemande($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This demande does not exist.')
            );
        }
    
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });   
                  
        /************************************/
        
        $form = $this->createForm(new DemandeFormType(), $demande);
         
        $demandeFiltres = new Demande(); // On créé notre objet      
        $formFiltres = $this->get('form.factory')->create(new DemandeFormType(), $demandeFiltres); // Filtres Form
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices(); 
        
        /***************Formulaire select Portefeuilles****************/
        $portefeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
        $portefeuilles = $portefeuilleManager->loadAllPortefeuille(); // on accède aux service et on récupère les méthodes dans portefeuilleManager
        
        $formModal = $this->get('form.factory')->create(new SelectPortefeuilleModalType(), $portefeuilles);        
        
        $options2 = $formModal->get('portefeuille')->getConfig()->getOptions();
        $choices2 = $options2['choice_list']->getChoices();            
        /***************************************************************/
        // DemandeBudget Form
        $DemandeBudget = new DemandeBudget();  
        $formBudget = $this->createForm(new DemandeBudgetFormType(), $DemandeBudget);
        
        //On récupère toutes les tuples du budget actuel
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findBy(array('demande' => $demande)); // Critere
 
        // On trie les budgets dans l'ordre CHRONO par date
        usort($listDemandeBudget, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /***************************************************************/
        
        // DemandeInstance Form
        $DemandeListeInstance = new DemandeListeInstance();  
        $formInstance = $this->createForm(new DemandeListeInstanceFormType(), $DemandeListeInstance);
        
        //On récupère liste des tuples instances de la Demande
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
        $listDemandeInstance = $repository->findBy(array('demande' => $demande)); // Critere
        
        // On trie les instances dans l'ordre CHRONO par date
        usort($listDemandeInstance, function($a, $b) {
          return ($a->getDatePrev() < $b->getDatePrev()) ? -1 : 1;
        });                
        /***************************************************************/         

        $form->handleRequest($request);
        if ($form->isSubmitted()) {                
        //if('POST' == $request->getMethod()) { // Si on a posté le formulaire
            //$form->submit($request->request->get($form->getName()));                       
           
           //if ($form->isValid()) { // Si le formulaire est valide
                
                $demande->setReferenceDemande($reference);
                $referencePortefeuille=$this->getRequest()->request->get('referencePortefeuille');
                $portefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadPortefeuille($referencePortefeuille);
                // On met a jour le typeEnveloppe
                $demande->setTypeEnveloppe($portefeuille->getPortefeuilleEnveloppe()->getNom());
                    
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
        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(), 
            'formFiltres' => $formFiltres->createView(),
            'formModal' => $formModal->createView(), 
            'formInstance' => $formInstance->createView(), 
            'formBudget' => $formBudget->createView(), 
            'demande' => $demande,
            'listDemande' => $listDemande,
            'choices' => $choices, 
            'choices2' => $choices2, 
            'listDemandeBudget' => $listDemandeBudget, 
            'listDemandeInstance' => $listDemandeInstance,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut)); 
    }      
    
    
    public function deleteDemandeAction($reference)
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/        
        
        // On vérifie que la demande existe
        if(!$demande = $this->get('nipa_demande.demande_manager')->loadDemande($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This demande does not exist.')
            );
        }
        
        $em = $this->getDoctrine()->getEntityManager();

        //On récupère tous le budget         
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findByDemande($demande);           

        //On récupère toutes les instances
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
        $listDemandeListeInstance = $repository->findByDemande($demande); 
        
        // On supprime AVANT les éléments des tables où le portefeuille (id) est une clé étrangère
        foreach($listDemandeBudget as $budget)
        {
            $em->remove($budget);
        }
        foreach($listDemandeListeInstance as $instance)
        {
            $em->remove($instance);
        }
        
        // On supprimer tous les portefeuilles liés à la Demande
        $listPortefeuilles = $demande->getPortefeuillesToArray();
        foreach($listPortefeuilles as $portefeuille)
        {
            $portfeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
            $portefeuille->removeDemandes($demande);
        }

        $em->flush();

        // On peut maintenant supprimer la demande même
        $this->get('nipa_demande.demande_manager')->deleteDemande($demande);     
        
        $this->get('session')->getFlashBag()->add('success','Suppression effectuée');  
        return new RedirectResponse($this->generateUrl('demande'));                     
    }        
    
    
    
    /**
    *  ADD a Portefeuille to a Demande
    * 
    */
    public function addPortefeuillesAction($reference)
    {
         /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/       
        $request = $this->get('request');
        
        $droit = 0;
        $user = $this->getUser();
            
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSDemande() == 1) || ($groupe->getPermission()->getLDemande() == 1)) // Si oui on test les droits d'accès
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
        
        

        $idPortefeuilles=$this->getRequest()->get('idPortefeuilles');
        $demande = $this->get('nipa_demande.demande_manager')->loadDemande($reference);
   
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });        
                  
        /************************************/
        
        $form = $this->createForm(new DemandeFormType(), $demande);
         
        $demandeFiltres = new Demande(); // On créé notre objet      
        $formFiltres = $this->get('form.factory')->create(new DemandeFormType(), $demandeFiltres); // Filtres Form
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();  
        
        /***************Formulaire select Portefeuilles****************/
        $portefeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
        $portefeuilles = $portefeuilleManager->loadAllPortefeuille(); // on accède aux service et on récupère les méthodes dans portefeuilleManager
        
        $formModal = $this->get('form.factory')->create(new SelectPortefeuilleModalType(), $portefeuilles);        
        
        $options2 = $formModal->get('portefeuille')->getConfig()->getOptions();
        $choices2 = $options2['choice_list']->getChoices();            
        /***************************************************************/
        // DemandeBudget Form
        $DemandeBudget = new DemandeBudget();  
        $formBudget = $this->createForm(new DemandeBudgetFormType(), $DemandeBudget);
        
        //On récupère toutes les tuples du budget actuel
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findBy(array('demande' => $demande)); // Critere
 
        // On trie les budgets dans l'ordre CHRONO par date
        usort($listDemandeBudget, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /***************************************************************/
        
        // DemandeInstance Form
        $DemandeListeInstance = new DemandeListeInstance();  
        $formInstance = $this->createForm(new DemandeListeInstanceFormType(), $DemandeListeInstance);
        
        //On récupère liste des tuples instances de la Demande
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
        $listDemandeInstance = $repository->findBy(array('demande' => $demande)); // Critere
        
        // On trie les instances dans l'ordre CHRONO par date
        usort($listDemandeInstance, function($a, $b) {
          return ($a->getDatePrev() < $b->getDatePrev()) ? -1 : 1;
        });        
        /***************************************************************/  
        
        // Si soumet le formulaire
        if ('POST' == $request->getMethod()) {
            
           $formModal->submit($request->request->get($form->getName()));            
           //$formModal->handleRequest($request);
           //if ($formModal->isValid()) {
              
                $em = $this->getDoctrine()->getEntityManager();

                for($i = 0;$i < count($idPortefeuilles); $i++)
                {

                    $portfeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
                    $portefeuille = $portfeuilleManager->loadPortefeuille(array('referencePortefeuille' => $idPortefeuilles[$i]));

                    $portefeuille->addDemandes($demande);

                    $em->flush();
                }	
                
                $portefeuille = $portfeuilleManager->loadPortefeuille(array('referencePortefeuille' => $idPortefeuilles[0]));
                $this->get('session')->getFlashBag()->set('success',
                $this->get('translator')->trans('Demande '.$demande->getreferenceDemande().' ajoutée aux portefeuille '.$portefeuille->getNom())
                );
                
                
                // On redirige vers la page de modification du portefeuille
                return new RedirectResponse($this->generateUrl('demande_edit', array(
                  'reference' => $demande->getReferenceDemande()
               )));
            //}
        }

        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(), 
            'formFiltres' => $formFiltres->createView(),
            'formModal' => $formModal->createView(), 
            'formInstance' => $formInstance->createView(), 
            'formBudget' => $formBudget->createView(), 
            'demande' => $demande,
            'listDemande' => $listDemande,
            'choices' => $choices, 
            'choices2' => $choices2, 
            'listDemandeBudget' => $listDemandeBudget, 
            'listDemandeInstance' => $listDemandeInstance,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut)); 
    }
    
    public function deletePortefeuillesAction(Request $request, $referencePortefeuille, $referenceDemande)
    {
         /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/          
        $request = $this->get('request');         
        
        $demande = $this->get('nipa_demande.demande_manager')->loadDemande($referenceDemande);

        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });          
                  
        /************************************/
        
        $form = $this->createForm(new DemandeFormType(), $demande);
         
        $demandeFiltres = new Demande(); // On créé notre objet      
        $formFiltres = $this->get('form.factory')->create(new DemandeFormType(), $demandeFiltres); // Filtres Form
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();  
        
        /***************Formulaire select Portefeuilles****************/
        $portefeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
        $portefeuilles = $portefeuilleManager->loadAllPortefeuille(); // on accède aux service et on récupère les méthodes dans portefeuilleManager
        
        $formModal = $this->get('form.factory')->create(new SelectPortefeuilleModalType(), $portefeuilles);        
        
        $options2 = $formModal->get('portefeuille')->getConfig()->getOptions();
        $choices2 = $options2['choice_list']->getChoices();            
        /***************************************************************/
        // DemandeBudget Form
        $DemandeBudget = new DemandeBudget();  
        $formBudget = $this->createForm(new DemandeBudgetFormType(), $DemandeBudget);
        
        //On récupère toutes les tuples du budget actuel
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findAll();  

        // On trie les budgets dans l'ordre CHRONO par date
        usort($listDemandeBudget, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /***************************************************************/
   
        $em = $this->getDoctrine()->getEntityManager();

        // On efface un portefeuille d'une demande
        $portfeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
        $portefeuille = $portfeuilleManager->loadPortefeuille(array('referencePortefeuille' => $referencePortefeuille));
        
        $em = $this->getDoctrine()->getManager();
        
        $portefeuille->removeDemandes($demande);
        
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'Demande '.$demande->getReferenceDemande().' retiré du Portefeuille '.$portefeuille->getNom().' ('.$portefeuille->getReferencePortefeuille().')');
        
        // On redirige vers la page de modification de la demande
        return new RedirectResponse($this->generateUrl('demande_edit', array(
          'reference' => $demande->getReferenceDemande()
       )));        
    }
    
    
    /**
    *  ADD a Description to a Demande
    * 
    */
    public function addDescriptionAction($reference)
    {
         /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/       
        $request = $this->get('request');
        
        $droit = 0;
        $user = $this->getUser();
            
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSDemande() == 1) || ($groupe->getPermission()->getLDemande() == 1)) // Si oui on test les droits d'accès
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
        
        $idPortefeuilles=$this->getRequest()->get('idPortefeuilles');
        $demande = $this->get('nipa_demande.demande_manager')->loadDemande($reference);
   
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });      
                  
        /************************************/
        
        $form = $this->createForm(new DemandeFormType(), $demande);
         
        $demandeFiltres = new Demande(); // On créé notre objet      
        $formFiltres = $this->get('form.factory')->create(new DemandeFormType(), $demandeFiltres); // Filtres Form
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();  
        
        /***************Formulaire select Portefeuilles****************/
        $portefeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
        $portefeuilles = $portefeuilleManager->loadAllPortefeuille(); // on accède aux service et on récupère les méthodes dans portefeuilleManager
        
        $formModal = $this->get('form.factory')->create(new SelectPortefeuilleModalType(), $portefeuilles);        
        
        $options2 = $formModal->get('portefeuille')->getConfig()->getOptions();
        $choices2 = $options2['choice_list']->getChoices();            
        /***************************************************************/
        // DemandeBudget Form
        $DemandeBudget = new DemandeBudget();  
        $formBudget = $this->createForm(new DemandeBudgetFormType(), $DemandeBudget);
        
        //On récupère toutes les tuples du budget actuel
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findBy(array('demande' => $demande)); // Critere
 
        // On trie les budgets dans l'ordre CHRONO par date
        usort($listDemandeBudget, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /***************************************************************/
        
        // DemandeInstance Form
        $DemandeListeInstance = new DemandeListeInstance();  
        $formInstance = $this->createForm(new DemandeListeInstanceFormType(), $DemandeListeInstance);
        
        //On récupère liste des tuples instances de la Demande
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
        $listDemandeInstance = $repository->findBy(array('demande' => $demande)); // Critere
        
        // On trie les instances dans l'ordre CHRONO par date
        usort($listDemandeInstance, function($a, $b) {
          return ($a->getDatePrev() < $b->getDatePrev()) ? -1 : 1;
        });        
        /***************************************************************/ 
        
        // Si soumet le formulaire
        if ('POST' == $request->getMethod()) {
            
           $formModal->submit($request->request->get($form->getName()));            
           //$formModal->handleRequest($request);
           //if ($formModal->isValid()) {
              
                $em = $this->getDoctrine()->getEntityManager();

                for($i = 0;$i < count($idPortefeuilles); $i++)
                {

                    $portfeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
                    $portefeuille = $portfeuilleManager->loadPortefeuille(array('referencePortefeuille' => $idPortefeuilles[$i]));

                    $portefeuille->addDemandes($demande);

                    $em->flush();
                }	
                
                $portefeuille = $portfeuilleManager->loadPortefeuille(array('referencePortefeuille' => $idPortefeuilles[0]));
                $this->get('session')->getFlashBag()->set('success',
                $this->get('translator')->trans('Demande '.$demande->getreferenceDemande().' ajoutée aux portefeuille '.$portefeuille->getNom())
                );
                
                
                // On redirige vers la page de modification du portefeuille
                return new RedirectResponse($this->generateUrl('demande_edit', array(
                  'reference' => $demande->getReferenceDemande()
               )));
            //}
        }

        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(),
            'formFiltres' => $formFiltres->createView(),
            'formModal' => $formModal->createView(), 
            'formInstance' => $formInstance->createView(), 
            'formBudget' => $formBudget->createView(), 
            'demande' => $demande,
            'listDemande' => $listDemande,
            'choices' => $choices, 
            'choices2' => $choices2, 
            'listDemandeBudget' => $listDemandeBudget, 
            'listDemandeInstance' => $listDemandeInstance,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut)); 
    }    
    
    /**
    *  EDIT budget actuel of a Demande
    * 
    */
    public function editBudgetAction($reference)    
    {
        
        $request = $this->get('request');

        // On vérifie que l'objet existe
        if(!$demande = $this->get('nipa_demande.demande_manager')->loadDemande($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This demande does not exist.')
            );
        }
     
        /***************************************************************/
        // DemandeBudget Form
        $DemandeBudget = new DemandeBudget();  
        $formBudget = $this->createForm(new DemandeBudgetFormType(), $DemandeBudget);
        
        //On récupère toutes les tuples du budget actuel
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findBy(array('demande' => $demande)); // Critere
 
        // On trie les budgets dans l'ordre CHRONO par date
        usort($listDemandeBudget, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /***************************************************************/     
        
        if ($request->isXmlHttpRequest()) {
            //return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 200);
            
            $formBudget->handleRequest($request);
            if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
                
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
 
                $ipp = $data["IPP"];
                $var = $data["date"];
                $date = str_replace('/', '-', $var);
                $format = date('Y-m-d', strtotime($date));     
                $time = new \DateTime($format);
                $montant =$data["montant"];
                $comment=$data["comment"];
                
                $DemandeBudget->setIPP($ipp);
                $DemandeBudget->setDate($time);
                $DemandeBudget->setMontant($montant);
                $DemandeBudget->setCommentaires($comment);
                $DemandeBudget->setDemande($demande);

                $em = $this->getDoctrine()->getManager();
                $em->persist($DemandeBudget);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success','Ajout Budget effectué');  

                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response;   
            }
        }
        
    }          
    
    
   /**
    *  DELETE Budget actu of a Demande
    * 
    */
    public function deleteBudgetAction($reference)    
    {
        
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($entity);
                $em->flush();
                
                $this->get('session')->getFlashBag()->set('success', "Suppression effectuée avec succès!");            
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
        }
    }       
    
    /**
    *  ADD Instance of a Demande
    * 
    */
    public function addInstanceAction($reference)    
    {
   
        $request = $this->get('request');
            
        // On vérifie que l'objet existe
        if(!$demande = $this->get('nipa_demande.demande_manager')->loadDemande($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This demande does not exist.')
            );
        }
 
        /***************************************************************/
        // DemandeInstance Form
        $DemandeListeInstance = new DemandeListeInstance();  
        $formInstance = $this->createForm(new DemandeListeInstanceFormType(), $DemandeListeInstance);
        
        //On récupère liste des tuples instances de la Demande
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
        $listDemandeInstance = $repository->findBy(array('demande' => $demande)); // Critere
        
        // On trie les instances dans l'ordre CHRONO par date
        usort($listDemandeInstance, function($a, $b) {
          return ($a->getDatePrev() < $b->getDatePrev()) ? -1 : 1;
        });        
        /***************************************************************/        
        
        if ($request->isXmlHttpRequest()) {
            //return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 200);
            
            $formInstance->handleRequest($request);
            if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
                
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);

                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');            
                $instance = $repository->findOneBy(array('id' => $data["nipa_projet_demande_instance"]["instance"]));
                
                $var = $data["nipa_projet_demande_instance"]["datePrev"];
                $date = str_replace('/', '-', $var);
                $format = date('Y-m-d', strtotime($date));     
                $datePrev = new \DateTime($format);
                //$dateRev=$data["nipa_projet_demande_instance"]["dateRev"];
                /*if (isset($data["nipa_projet_demande_instance"]["validationEffective"])){
                    $validationEffective=$data["nipa_projet_demande_instance"]["validationEffective"];
                    $DemandeListeInstance->setValidationEffective($validationEffective);
                }*/
                $remarques=$data["nipa_projet_demande_instance"]["remarques"];
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatutInstance');            
                $statut = $repository->findOneBy(array('id' => $data["nipa_projet_demande_instance"]["statut"]));
                                
                $DemandeListeInstance->setInstance($instance);
                $DemandeListeInstance->setDatePrev($datePrev);
                //$DemandeListeInstance->setDateRev($dateRev);
                $DemandeListeInstance->setRemarques($remarques);
                $DemandeListeInstance->setStatut($statut);
                $DemandeListeInstance->setDemande($demande);

                $em = $this->getDoctrine()->getManager();
                $em->persist($DemandeListeInstance);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success','Ajout instance effectué');  

                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response;   
            }
        }

    }    
    
   /**
    *  DELETE Instance of a Demande
    * 
    */
    public function deleteInstanceAction($reference)    
    {

        /***********************************************************/
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($entity);
                $em->flush();
                
                $this->get('session')->getFlashBag()->set('success', "Suppression effectuée avec succès!");            
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
        }
    } 
    
    /**
    *  ADD FILTRES
    * 
    */
    public function filtresAction()
    {
        /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/       
        $request = $this->get('request');
        
        $droit = 0;
        $user = $this->getUser();
            
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSDemande() == 1) || ($groupe->getPermission()->getLDemande() == 1)) // Si oui on test les droits d'accès
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
        
        /*******************************************/

        $criteres=$this->getRequest()->get('criteres');
   
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });        
                  
        /************************************/
        
        $demande = new Demande(); // On créé notre objet      
        $form = $this->createForm(new DemandeFormType(), $demande);
         
        $demandeFiltres = new Demande(); // On créé notre objet      
        $formFiltres = $this->get('form.factory')->create(new DemandeFormType(), $demandeFiltres); // Filtres Form
        
        $options = $form->get('portefeuille')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();  
        
        /***************Formulaire select Portefeuilles****************/
        $portefeuilleManager = $this->get('nipa_portefeuille.portefeuille_manager');
        $portefeuilles = $portefeuilleManager->loadAllPortefeuille(); // on accède aux service et on récupère les méthodes dans portefeuilleManager
        
        $formModal = $this->get('form.factory')->create(new SelectPortefeuilleModalType(), $portefeuilles);        
        
        $options2 = $formModal->get('portefeuille')->getConfig()->getOptions();
        $choices2 = $options2['choice_list']->getChoices();            
        /***************************************************************/
        // DemandeBudget Form
        $DemandeBudget = new DemandeBudget();  
        $formBudget = $this->createForm(new DemandeBudgetFormType(), $DemandeBudget);
        
        //On récupère toutes les tuples du budget actuel
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeBudget');
        $listDemandeBudget = $repository->findBy(array('demande' => $demande)); // Critere
 
        // On trie les budgets dans l'ordre CHRONO par date
        usort($listDemandeBudget, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /***************************************************************/
        
        // DemandeInstance Form
        $DemandeListeInstance = new DemandeListeInstance();  
        $formInstance = $this->createForm(new DemandeListeInstanceFormType(), $DemandeListeInstance);
        
        //On récupère liste des tuples instances de la Demande
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeListeInstance');
        $listDemandeInstance = $repository->findBy(array('demande' => $demande)); // Critere
        
        // On trie les instances dans l'ordre CHRONO par date
        usort($listDemandeInstance, function($a, $b) {
          return ($a->getDatePrev() < $b->getDatePrev()) ? -1 : 1;
        });        
        /***************************************************************/  
        
        // Si soumet le formulaire
        if ('POST' == $request->getMethod()) {
            
           $formFiltres->submit($request->request->get($form->getName()));            
           //$formModal->handleRequest($request);
           //if ($formModal->isValid()) {
                
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($criteres);
                
                $em = $this->getDoctrine()->getEntityManager();
                
                $merge=0;
                $search=0;
                $where = array();
                for($i = 0;$i < count($criteres); $i++)
                {
                    //["Reference", "Priorite", "Titre", "TypeEnveloppe", "StatutDemande", "Portefeuille", "Direction", "EM", "Offres", "TypeProjet", "Divers", "PM", "Interlocuteur", "SDM", "Search"]
                    if($criteres[$i] == "Reference")
                    {
                        $reference = $data["Reference"];
                        $where["referenceDemande"] = $reference;
                    }
                    elseif ($criteres[$i] == "Priorite")
                    {
                        $priorite = $data["nipa_projet_demande"]["priorite"];
                        $where["priorite"] = $priorite;
                    }
                    elseif ($criteres[$i] == "Titre")
                    {
                        $titre = $data["Titre"];
                        $where["nom"] = $titre;
                    }
                    elseif ($criteres[$i] == "TypeEnveloppe")
                    {
                        $typeEnveloppe = $data["TypeEnveloppe"];
                        $where["typeEnveloppe"] = $typeEnveloppe;
                    }                    
                    elseif ($criteres[$i] == "StatutDemande")
                    {
                        $statutDemande = $data["nipa_projet_demande"]["demandeStatut"];
                        $where["demandeStatut"] = $statutDemande;
                    }                    
                    elseif ($criteres[$i] == "Portefeuille")
                    {
                        $portefeuille = $data["Portefeuille"];
                        
                        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:Portefeuille');
                        $portefeuille = $repository->findBy(array('referencePortefeuille' => $portefeuille));                        
                        
                        $listeDemandes = $portefeuille[0]->getDemandesToArray();
                      
                        $merge = 1;
                    }
                    elseif ($criteres[$i] == "Direction")
                    {
                        $direction = $data["nipa_projet_demande"]["direction"];
                        $where["direction"] = $direction;
                    }                    
                    elseif ($criteres[$i] == "EM")
                    {
                        $em = $data["nipa_projet_demande"]["entiteMetier"];
                        $where["entiteMetier"] = $em;
                    }                    
                    elseif ($criteres[$i] == "Offres")
                    {
                        $offres = $data["nipa_projet_demande"]["offres"];
                        $where["offres"] = $offres;
                    }
                    elseif ($criteres[$i] == "TypeProjet")
                    {
                        $typeProjet = $data["nipa_projet_demande"]["typeProjet"];
                        $where["typeProjet"] = $typeProjet;
                    }     
                    elseif ($criteres[$i] == "Divers")
                    {
                        $divers = $data["nipa_projet_demande"]["divers"];
                        $where["divers"] = $divers;
                    }                    
                    elseif ($criteres[$i] == "PM")
                    {
                        $pm = $data["nipa_projet_demande"]["porteurMetier"];
                        $where["porteurMetier"] = $pm;
                    }
                    elseif ($criteres[$i] == "Interlocuteur")
                    {
                        $interlocuteur = $data["nipa_projet_demande"]["interlocuteurMOA"];
                        $where["interlocuteurMOA"] = $interlocuteur;
                    }                    
                    elseif ($criteres[$i] == "SDM")
                    {
                        $sdm = $data["nipa_projet_demande"]["SDM"];
                        $where["SDM"] = $sdm;
                    }
                    elseif ($criteres[$i] == "Search") 
                    {
                        $listSearch = $data["Search"];
                        // On requete pour rechercher (LIKE) les références Demande en fct du NOM
                        $listDemandeSearch = $this->getDoctrine()->getManager()
                                ->createQuery('Select d from NIPAProjetBundle:Demande d Where d.nom LIKE :search')
                                ->setParameter('search', '%'.$listSearch.'%')
                                ->getResult();    
                        
                        $search = 1;               
                    }   
                }
                
                //\Doctrine\Common\Util\Debug::dump($where);
                if($search == 0) // Si recherche globale, pas besoin de filtrer
                {
                    $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:Demande');
                    $listDemande = $repository->findBy(
                        $where,                                   // Critere
                        array('referenceDemande' => 'asc')        // Tri
                    );
                } 
                //\Doctrine\Common\Util\Debug::dump(sizeof($listDemande));
                
                $listDemandeFiltres = array();
                if($merge == 1) // Si on filtre sur portefeuille --> on applique les demandes trouvées (via requêtes) sur les demandes du portefeuille selectionné
                {                    
                    for($i=0; $i < sizeof($listeDemandes); $i++)
                    {
                        for($z=0; $z < sizeof($listDemande); $z++)
                        {
                            if($listeDemandes[$i]->getReferenceDemande() == $listDemande[$z]->getReferenceDemande())
                            {
                                $listDemandeFiltres[sizeof($listDemandeFiltres)] = $listeDemandes[$i];
                            }
                        }
                    }
                }
                else if($search == 1) // Si recherche globale
                {
                    $listDemandeFiltres = $listDemandeSearch;
                }
                else // Sinon on renvoie juste les demande trouvées (via requêtes)
                {
                    $listDemandeFiltres = $listDemande;
                }
                    

                $this->get('session')->getFlashBag()->set('notice',
                $this->get('translator')->trans('Filtres appliqués: '.sizeof($listDemandeFiltres).' Demande(s)')
                );
                
                // On redirige vers la page de modification du portefeuille
                return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array(
                    'user' => $user, 
                    'form' => $form->createView(), 
                    'formFiltres' => $formFiltres->createView(),
                    'formModal' => $formModal->createView(), 
                    'formInstance' => $formInstance->createView(), 
                    'formBudget' => $formBudget->createView(), 
                    'demande' => $demande,
                    'listDemande' => $listDemandeFiltres,
                    'choices' => $choices, 
                    'choices2' => $choices2, 
                    'listDemandeBudget' => $listDemandeBudget, 
                    'listDemandeInstance' => $listDemandeInstance,
                    'listPortefeuille' => $listPortefeuille, 
                    'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
                    'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
                    'listPortefeuilleStatut' => $listPortefeuilleStatut)); 
            //}
        }

        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(), 
            'formFiltres' => $formFiltres->createView(),
            'formModal' => $formModal->createView(), 
            'formInstance' => $formInstance->createView(), 
            'formBudget' => $formBudget->createView(), 
            'demande' => $demande,
            'listDemande' => $listDemande,
            'choices' => $choices, 
            'choices2' => $choices2, 
            'listDemandeBudget' => $listDemandeBudget, 
            'listDemandeInstance' => $listDemandeInstance,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut)); 
    }    
}