<?php

namespace NIPA\UserBundle\Controller;

use NIPA\UserBundle\Entity\Utilisateur;
use NIPA\UserBundle\Entity\Groupe;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdministrationController extends Controller
{


    public function showAction()
    {
        $user = $this->getUser();
        
        if ($user->getAdmin() == false) { // On test si user Admin pour avoir accès à la section Administration
            throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
        }
        
        //return array() List ALL Users;
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
 
        //return array() List ALL Groupes;
        $groupes = $this->get('nipa_groupe.groupe_manager')->loadAllGroupe();
        
      return $this->render('NIPAUserBundle:Administration:administration.html.twig', array('users' => $users, 'groupes' => $groupes));       
    }
    
   public function deleteUserAction($identifiant)
    {
        // On efface un utilisateur
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('Identifiant' => $identifiant)); // on accède aux service et on récupère les méthodes dans  UserManager      
        $userManager -> deleteUser($user);
        
        $this->get('session')->getFlashBag()->add('success','Utilisateur '.$user->getNom().' '.$user->getPrenom().' ('.$user->getIdentifiant(). ') effacé');  
        return $this->redirect($this->generateUrl('administration'));               
    }
    
   public function deleteGroupeAction($groupeId)
    {
        // On efface un groupe
        $groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId);
        $this->get('nipa_groupe.groupe_manager') -> deleteGroupe($groupe);
        
        $this->get('session')->getFlashBag()->add('success','Groupe '.$groupe->getNom().' effacé');
        return $this->redirect($this->generateUrl('administration'));               
    }    
}  