<?php

namespace NIPA\ProjetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProjetController extends Controller
{
	
    public function indexAction()
    {
        //return array();
        return $this->render('NIPAProjetBundle:Projet:projet.html.twig', array());
    } 

}