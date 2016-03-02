<?php

namespace NIPA\ProjetBundle\Controller;

use NIPA\ProjetBundle\Form\Type\ProjetFormType;

use NIPA\ProjetBundle\Entity\Projet;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class ProjetController extends Controller
{
	
    public function indexAction()
    {
        
        
        $droit = 0;
        $user = $this->getUser();
    
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSProjet() == 1) || ($groupe->getPermission()->getLProjet() == 1)) // Si oui on test les droits d'accès
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

        $projet = new Projet(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new ProjetFormType(), $projet); // On bind l'objet à notre formulaire 
        
        /*************************************************/     
       
        //return array();
        return $this->render('NIPAProjetBundle:Projet:projet.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(),
            'projet' => $projet, 
            'listDemande' => $listDemande,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut
            )); 
    } 
    
    
    
    /**
    *  ADD a Projet
    * 
    */
    public function addProjetAction()
    {
        
        $droit = 0;
        $user = $this->getUser();
    
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSProjet() == 1) || ($groupe->getPermission()->getLProjet() == 1)) // Si oui on test les droits d'accès
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

        $projet = new Projet(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new ProjetFormType(), $projet); // On bind l'objet à notre formulaire 
        
        /*************************************************/     
       
        //return array();
        return $this->render('NIPAProjetBundle:Projet:projet.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(),
            'projet' => $projet, 
            'listDemande' => $listDemande,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut
            )); 
    } 
    
  
    /**
    *  SELECT INFO Projet with a Demande
    * 
    */
    public function loadProjetDemandeAction()    
    {
   
        $request = $this->get('request');
        
        if ($request->isXmlHttpRequest()) {
            //return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 200);
 
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);

                $referenceDemande=$data["referenceDemande"];

                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:Demande');            
                $demande = $repository->findOneBy(array('referenceDemande' => $referenceDemande));
                
                return new JsonResponse(array(
                    'titre' => $demande->getNom(),
                    'typeEnveloppe' => $demande->getTypeEnveloppe(),
                    'priorite' => $demande->getPriorite()->getNom(),
                    'direction' => $demande->getDirection()->getNom(),
                    'entiteMetier' => $demande->getEntiteMetier()->getNom(),
                    'offres' => $demande->getOffres()->getNom(),
                    'typeProjet' => $demande->getTypeProjet()->getNom(),
                    'interlocuteurMOA' => $demande->getInterlocuteurMOA()->getNom(),
                    'porteurMetier' => $demande->getPorteurMetier()->getNom(),
                    'SDM' => $demande->getSDM()->getNom()
                    ));

        }
            
        return new Response("Erreur requête...");     
    }    
    
}