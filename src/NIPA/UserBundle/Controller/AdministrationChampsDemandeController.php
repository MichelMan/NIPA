<?php

namespace NIPA\UserBundle\Controller;

use NIPA\ProjetBundle\Entity\DemandeDirection;
use NIPA\ProjetBundle\Entity\DemandeDivers;
use NIPA\ProjetBundle\Entity\DemandeEntiteMetier;
use NIPA\ProjetBundle\Entity\DemandeInstance;
use NIPA\ProjetBundle\Entity\DemandeInterlocuteurMOA;
use NIPA\ProjetBundle\Entity\DemandeOffres;
use NIPA\ProjetBundle\Entity\DemandePorteurMetier;
use NIPA\ProjetBundle\Entity\DemandePriorite;
use NIPA\ProjetBundle\Entity\DemandeSDM;
use NIPA\ProjetBundle\Entity\DemandeStatut;
use NIPA\ProjetBundle\Entity\DemandeStatutInstance;
use NIPA\ProjetBundle\Entity\DemandeTypeProjet;

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
    
    
  /**
    *  EDIT Champs InterlocuteurMOA
    * 
    */
    public function editChampInterlocuteurMOAAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInterlocuteurMOA');
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
    *  DELETE Champs InterlocuteurMOA
    * 
    */
    public function deleteChampInterlocuteurMOAAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInterlocuteurMOA');
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
    *  ADD Champs InterlocuteurMOA
    * 
    */
    public function addChampInterlocuteurMOAAction()    
    {      
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInterlocuteurMOA');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cet interlocuteur existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                                
                $entity = new DemandeInterlocuteurMOA();
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
    *  EDIT Champs Offres
    * 
    */
    public function editChampOffresAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeOffres');
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
    *  DELETE Champs Offres
    * 
    */
    public function deleteChampOffresAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeOffres');
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
    *  ADD Champs InterlocuteurMOA
    * 
    */
    public function addChampOffresAction()    
    {      
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeOffres');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette offre existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                                
                $entity = new DemandeOffres();
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
    *  EDIT Champs Porteur Métier
    * 
    */
    public function editChampPMAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePorteurMetier');
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
    *  DELETE Champs Porteur Métier
    * 
    */
    public function deleteChampPMAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePorteurMetier');
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
    *  ADD Champs Porteur Métier
    * 
    */
    public function addChampPMAction()    
    {        
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePorteurMetier');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Ce Porteur Métier existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                                
                $entity = new DemandePorteurMetier();
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
    *  EDIT Champs Priorite
    * 
    */
    public function editChampPrioriteAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePriorite');
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
    *  DELETE Champs Priorite
    * 
    */
    public function deleteChampPrioriteAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePriorite');
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
    *  ADD Champs Priorite
    * 
    */
    public function addChampPrioriteAction()    
    {       
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePriorite');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Cette priorité existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                                
                $entity = new DemandePriorite();
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
    *  EDIT Champs SDM
    * 
    */
    public function editChampSDMAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeSDM');
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
    *  DELETE Champs SDM
    * 
    */
    public function deleteChampSDMAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeSDM');
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
    *  ADD Champs SDM
    * 
    */
    public function addChampSDMAction()    
    {       
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeSDM');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Ce SDM existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                                
                $entity = new DemandeSDM();
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
    *  EDIT Champs Statut Demande
    * 
    */
    public function editChampStatutAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatut');
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
    *  DELETE Champs Statut Demande
    * 
    */
    public function deleteChampStatutAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatut');
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
    *  ADD Champs Statut Demande
    * 
    */
    public function addChampStatutAction()    
    {       
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatut');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Ce statut existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                //On récupère toutes les instances
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatut');
                $listStatuts = $repository->findAll();       
                
                $id = substr($listStatuts[sizeof($listStatuts)-1]->getReference(), -1) + 1;
                
                $entity = new DemandeStatut();
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
    
  /**
    *  EDIT Champs Statut Instance
    * 
    */
    public function editChampStatutInstanceAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatutInstance');
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
    *  DELETE Champs Statut Instance
    * 
    */
    public function deleteChampStatutInstanceAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatutInstance');
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
    *  ADD Champs Statut Instance
    * 
    */
    public function addChampStatutInstanceAction()    
    {       
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeStatutInstance');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Ce statut existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                                
                $entity = new DemandeStatutInstance();
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
    *  EDIT Champs Type Projet
    * 
    */
    public function editChampTypeProjetAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeTypeProjet');
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
    *  DELETE Champs Type Projet
    * 
    */
    public function deleteChampTypeProjetAction()    
    {
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeTypeProjet');
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
    *  ADD Champs Type Projet
    * 
    */
    public function addChampTypeProjetAction()    
    {     
        
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
       
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeTypeProjet');

                // On vérifie que l'objet n'existe pas déjà
                if($entity = $repository->findOneBy(array('nom' => $data["nom"]))) {
                    throw new NotFoundHttpException(
                        $this->get('translator')->trans('Ce Type de Projet existe déjà')
                    );
                    return new JsonResponse(array('message' => 'Error'), 400);                                        
                }

                                
                $entity = new DemandeTypeProjet();
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