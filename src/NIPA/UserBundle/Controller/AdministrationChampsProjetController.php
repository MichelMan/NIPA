<?php

namespace NIPA\UserBundle\Controller;

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


class AdministrationChampsProjetController extends Controller
{
    /**
    *  EDIT Champs Etape
    * 
    */
    public function editChampEtapeAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetEtape');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $entity->setNom($data["nom"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }  
    
    /**
    *  EDIT Champs Phase
    * 
    */
    public function editChampPhaseAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $entity->setNom($data["nom"]);
                $entity->setReference($data["reference"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }      

    /**
    *  EDIT Champs Phase ALL DRAG & DROP
    * 
    */
    public function editChampPhaseALLAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                for($i=0; $i<sizeof($data["array"]); $i++)
                {
                    $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
                    $entity = $repository->findOneBy(array('id' => $data["array"][$i]));

                    $entity->setReference($i+1);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();             
                }
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }     
    
}  