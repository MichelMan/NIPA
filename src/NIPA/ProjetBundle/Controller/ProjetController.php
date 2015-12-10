<?php

namespace NIPA\ProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


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
            return $this->render('NIPAUserBundle:Default:accueil.html.twig', array('droit' => $droit));
        }
        
        //return array();
        return $this->render('NIPAProjetBundle:Projet:projet.html.twig', array('user' => $user));            
    } 

}