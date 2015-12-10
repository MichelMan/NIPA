<?php

namespace NIPA\ProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DemandeController extends Controller
{
	
    public function indexAction()
    {
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
        
        //return array();
        return $this->render('NIPAProjetBundle:Demande:demande.html.twig', array('user' => $user));
    } 

}