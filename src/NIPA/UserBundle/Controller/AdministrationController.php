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
        
        /***********************************************************/
        
        //On récupère toutes les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listEnveloppes = $repository->findAll();          

        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listAnnees = $repository->findAll();     
        
        //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listStatuts = $repository->findAll();     
        
        /***********************************************************/
     
      return $this->render('NIPAUserBundle:Administration:administration.html.twig', array('users' => $users, 'groupes' => $groupes, 'listEnveloppes' => $listEnveloppes, 'listAnnees' => $listAnnees, 'listStatuts' => $listStatuts));       
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

    /**
    *  EDIT Champs Enveloppe
    * 
    */
    public function editChampEnveloppeAction()    
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