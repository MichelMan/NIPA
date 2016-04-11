<?php

namespace NIPA\UserBundle\Controller;

use NIPA\UserBundle\Entity\Utilisateur;
use NIPA\UserBundle\Entity\Groupe;

use NIPA\ProjetBundle\Entity\PortefeuilleEnveloppe;
use NIPA\ProjetBundle\Entity\PortefeuilleAnnee;
use NIPA\ProjetBundle\Entity\PortefeuilleStatut;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class AdministrationController extends Controller
{

    public function showAction()
    {
        /**********************DROIT SECTION************************/
        $request = Request::createFromGlobals();
        $droit = $request->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/
        
        //return array() List ALL Users;
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
 
        //return array() List ALL Groupes;
        $groupes = $this->get('nipa_groupe.groupe_manager')->loadAllGroupe();
        
        /**************************CHAMPS PORTEFEUILLE*********************************/
        
        //On récupère toutes les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listEnveloppes = $repository->findAll();          

        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listAnnees = $repository->findAll();     
        
        //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listStatuts = $repository->findAll();     
        
        /**************************CHAMPS DEMANDE*********************************/
        
        //On récupère toutes les directions
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDirection');
        $listDirections = $repository->findAll();          

        //On récupère tous les divers
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDivers');
        $listDivers = $repository->findAll();     
        
        //On récupère toutes les instances
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
        $listInstances = $repository->findAll();   
      
        //On récupère tous les EM
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeEntiteMetier');
        $listEntiteMetiers = $repository->findAll(); 
       
        //On récupère tous les interlocuteurs MOA
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInterlocuteurMOA');
        $listInterlocuteurs = $repository->findAll();          

        //On récupère toutes les Offres
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeOffres');
        $listOffres = $repository->findAll();     
        
        //On récupère tous les porteurs métiers
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePorteurMetier');
        $listPorteurs = $repository->findAll();   
      
        //On récupère toutes les priorités
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePriorite');
        $listPriorites = $repository->findAll();         

        //On récupère tous les SDM
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeSDM');
        $listSDM = $repository->findAll();          

        //On récupère tous les Statuts Demande
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatut');
        $listDemandeStatuts = $repository->findAll();     
        
        //On récupère tous les Statuts Instance
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatutInstance');
        $listStatutInstances = $repository->findAll();   
      
        //On récupère tous les types Projet
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeTypeProjet');
        $listTypeProjets = $repository->findAll(); 
        
        
        /**************************CHAMPS PROJET*********************************/
        
        //On récupère toutes les Etapes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetEtape');
        $listEtapes = $repository->findAll();          

        //On récupère toutes les Phases
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listPhases = $repository->findAll();     
        
        //On récupère toutes les instances
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
        $listProjetInstances = $repository->findAll();  
        
        //On récupère tous ls jalons Date
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetJalonDate');
        $listJalonDates = $repository->findAll();   
        
        //On récupère tous les livrables
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetLivrable');
        $listLivrables = $repository->findAll();             
        
         /***********************************************************/
       
      return $this->render('NIPAUserBundle:Administration:administration.html.twig', array(
          'users' => $users,
          'groupes' => $groupes, 
          'listEnveloppes' => $listEnveloppes, 
          'listAnnees' => $listAnnees, 
          'listStatuts' => $listStatuts,
          'listDirections' => $listDirections,
          'listDivers' => $listDivers,
          'listInstances' => $listInstances,
          'listEntiteMetiers' => $listEntiteMetiers,
          'listInterlocuteurs' => $listInterlocuteurs,
          'listOffres' => $listOffres,
          'listPorteurs' => $listPorteurs,
          'listPriorites' => $listPriorites,
          'listSDM' => $listSDM,
          'listDemandeStatuts' => $listDemandeStatuts,
          'listStatutInstances' => $listStatutInstances,
          'listTypeProjets' => $listTypeProjets,
          'listEtapes' => $listEtapes,
          'listPhases' => $listPhases,
          'listProjetInstances' => $listProjetInstances,
          'listJalonDates' => $listJalonDates,
          'listLivrables' => $listLivrables
          ));       
    }
    
    public function deleteUserAction($identifiant)
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/       
       
        // On efface un utilisateur
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('Identifiant' => $identifiant)); // on accède aux service et on récupère les méthodes dans  UserManager      
        $userManager -> deleteUser($user);
        
        $this->get('session')->getFlashBag()->add('success','Utilisateur '.$user->getNom().' '.$user->getPrenom().' ('.$user->getIdentifiant(). ') effacé');  
        return $this->redirect($this->generateUrl('administration'));               
    }
    
    public function deleteGroupeAction($groupeId)
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/
        
        // On efface un groupe
        $groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId);
        $this->get('nipa_groupe.groupe_manager') -> deleteGroupe($groupe);
        
        $this->get('session')->getFlashBag()->add('success','Groupe '.$groupe->getNom().' effacé');
        return $this->redirect($this->generateUrl('administration'));               
    }    
    
}  