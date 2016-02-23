<?php

namespace NIPA\UserBundle\Controller;

use NIPA\ProjetBundle\Entity\DemandeDirection;
use NIPA\ProjetBundle\Entity\DemandeDivers;
use NIPA\ProjetBundle\Entity\DemandeEntiteMetier;
use NIPA\ProjetBundle\Entity\DemandeInstance;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class AdministrationChampsDemandeController extends Controller
{
    /**
    *  EDIT Champs Direction
    * 
    */
    public function editChampDirectionAction()    
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
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDirection');
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
    *  DELETE Champs Direction
    * 
    */
    public function deleteChampDirectionAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDirection');
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
    *  ADD Champs Direction
    * 
    */
    public function addChampDirectionAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDirection');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette Direction existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                                            
                }
                
                $entity = new DemandeDirection();
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
    *  EDIT Champs Divers
    * 
    */
    public function editChampDiversAction()    
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
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDivers');
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
    *  DELETE Champs Divers
    * 
    */
    public function deleteChampDiversAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDivers');
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
    *  ADD Champs Divers
    * 
    */
    public function addChampDiversAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeDivers');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('valeur' => $data["valeur"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette valeur existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }
                
                $entity = new DemandeDivers();
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
    *  EDIT Champs EM
    * 
    */
    public function editChampEMAction()    
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
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeEntiteMetier');
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
    *  DELETE Champs EM
    * 
    */
    public function deleteChampEMAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeEntiteMetier');
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
    public function addChampEMAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeEntiteMetier');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette Entité Métier existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }
                
                $entity = new DemandeEntiteMetier();
                $entity->setNom($data["nom"]);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return new JsonResponse(array('message' => 'Success!'), 200);

                //$response = new JsonResponse(array('message' => 'Error'), 400);

                //return $response; 
                
        }
    }          
    
  /**
    *  EDIT Champs Instance
    * 
    */
    public function editChampInstanceAction()    
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
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
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
    *  DELETE Champs Instance
    * 
    */
    public function deleteChampInstanceAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
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
    *  ADD Champs Instance
    * 
    */
    public function addChampInstanceAction()    
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
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette instance existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                //On récupère toutes les instances
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
                $listInstances = $repository->findAll();       
                
                $id = substr($listInstances[sizeof($listInstances)-1]->getReference(), -1) + 1;
                
                $entity = new DemandeInstance();
                $entity->setNom($data["nom"]);
                $entity->setReference("Ref".$id);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return new JsonResponse(array('message' => 'Success!'), 200);

                //$response = new JsonResponse(array('message' => 'Error'), 400);

                //return $response; 
                
        }
    }              
}  