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


class AdministrationChampsPortefeuilleController extends Controller
{
    /**
    *  EDIT Champs Enveloppe
    * 
    */
    public function editChampEnveloppeAction()    
    {    
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
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
    *  DELETE Champs Enveloppe
    * 
    */
    public function deleteChampEnveloppeAction()    
    {       
  
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($entity);
                $em->flush();
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }   
    
   /**
    *  ADD Champs Enveloppe
    * 
    */
    public function addChampEnveloppeAction()    
    {     
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette enveloppe existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                                            
                }
                
                $entity = new PortefeuilleEnveloppe();
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
    *  EDIT Champs Annee
    * 
    */
    public function editChampAnneeAction()    
    {       
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $entity->setValeur($data["valeur"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }  
  
   /**
    *  DELETE Champs Annee
    * 
    */
    public function deleteChampAnneeAction()    
    {       
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($entity);
                $em->flush();
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }   
    
   /**
    *  ADD Champs Annee
    * 
    */
    public function addChampAnneeAction()    
    {        
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('valeur' => $data["valeur"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette année existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }
                
                $entity = new PortefeuilleAnnee();
                $entity->setValeur($data["valeur"]);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }
    
    
    /**
    *  EDIT Champs Statut
    * 
    */
    public function editChampStatutAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
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
    *  DELETE Champs Statut
    * 
    */
    public function deleteChampStatutAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
                $entity = $repository->findOneBy(array('id' => $data["id"]));
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($entity);
                $em->flush();
                
                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response; 
                
        }
    }   
    
   /**
    *  ADD Champs Statut
    * 
    */
    public function addChampStatutAction()    
    {       
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Ce statut existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }
                
                $entity = new PortefeuilleStatut();
                $entity->setNom($data["nom"]);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return new JsonResponse(array('message' => 'Success!'), 200);

                //$response = new JsonResponse(array('message' => 'Error'), 400);

                //return $response; 
                
        }
    }          
}  