<?php

namespace NIPA\UserBundle\Controller;

use NIPA\UserBundle\Form\Type\GroupeFormType;
use NIPA\UserBundle\Form\Type\SelectUserModalType;
use NIPA\UserBundle\Form\Type\PermissionFormType;

use NIPA\UserBundle\Entity\Groupe;
use NIPA\UserBundle\Entity\Utilisateur;
use NIPA\UserBundle\Entity\Permission;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class GroupeController extends Controller
{

    public function showAction($groupeId)
    {
        if (!$groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId)) {
            throw new NotFoundHttpException($this->get('translator')->trans('This groupe does not exist.'));
        }

        return $this->render('NIPAUserBundle:Groupe:groupe.html.twig', array('groupe' => $groupe));
    }

    /**
    *  ADD a Groupe
    * 
    */
   public function addGroupeAction()
   {
       $request = $this->get('request'); // On récupère l'objet request via le service container
       $groupe = new Groupe(); // On créé notre objet Groupe vierge

       $form = $this->get('form.factory')->create(new GroupeFormType(), $groupe); // On bind l'objet Groupe à notre formulaire GroupeFormType
	   
        /******2e formulaire en ARGUMENT*****/
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
        
        // On bind le groupe récupéré depuis la BDD au formulaire pour modification
        $formModal = $this->get('form.factory')->create(new SelectUserModalType(), $users);
     
        $options = $formModal->get('identifiant')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();       
        /************************************/       
 
        /******3e formulaire en ARGUMENT*****/       
        if($groupe->getPermission() == null)
        {
            $permission = new Permission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        else
        {
            $permission = $groupe->getPermission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        /************************************/       
        
        
       if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
           //$form->bindRequest($request); // On bind les données du form DEPRECATED
           $form->handleRequest($request);
           if ($form->isValid()) { // Si le formulaire est valide

               $this->get('nipa_groupe.groupe_manager')->saveGroupe($groupe); // On utilise notre Manager pour gérer la sauvegarde de l'objet

               // On envoi une 'flash' pour indiquer à l'utilisateur que le groupe est ajouté
               /*$this->get('session')->setFlash('notice', 
                   $this->get('translator')->trans('Nouveau groupe ajouté')
               ); DEPRECATED */
                $this->get('session')->getFlashBag()->set('notice',
                $this->get('translator')->trans('Nouveau groupe ajouté')
                );
                
               // On redirige vers la page de modification du groupe
               return new RedirectResponse($this->generateUrl('groupe_edit', array(
                   'groupeId' => $groupe->getId()
               )));
           }
       }
       
       return $this->render('NIPAUserBundle:Groupe:add.html.twig', array('form' => $form->createView(), 'formModal' => $formModal->createView(), 'formPermission' => $formPermission->createView(), 'groupe' => $groupe,  'choices' => $choices)); // On passe à Twig l'objet form et notre objet Groupe
   }
   
    /**
    *  EDIT a Groupe
    * 
    */
    public function editGroupeAction($groupeId)
    {
        
        /******1er formulaire de BASE********/
        $request = $this->get('request');
  
        // On vérifie que l'ID du groupe existe
        if (!$groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This groupe does not exist.')
            );
        }
        
        // On bind le groupe récupéré depuis la BDD au formulaire pour modification
        $form = $this->get('form.factory')->create(new GroupeFormType(), $groupe);
        /************************************/

        /******2e formulaire en ARGUMENT*****/
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
        
        $formModal = $this->get('form.factory')->create(new SelectUserModalType(), $users);
     
        $options = $formModal->get('identifiant')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();       
        /************************************/

        /******3e formulaire en ARGUMENT*****/       
        if($groupe->getPermission() == null)
        {
            $permission = new Permission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        else
        {
            $permission = $groupe->getPermission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        /************************************/       
        
        // Si le groupe soumet le formulaire
        //if ($request->getMethod() == 'POST') {
        if ('POST' == $request->getMethod()) {
            
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                
                $this->get('nipa_groupe.groupe_manager')->saveGroupe($groupe);
                
                //DEPRECATED
                //$this->get('session')->setFlash('notice',
                //    $this->get('translator')->trans('User updated.')
                //);
				
                    $this->get('session')->getFlashBag()->set('notice',
                    $this->get('translator')->trans('Groupe mise à jour')
                );
				
                return new RedirectResponse($this->generateUrl('groupe_edit', array(
                    'groupeId' => $groupe->getId()
                )));
            }                   
        }

        return $this->render('NIPAUserBundle:Groupe:add.html.twig', array('form' => $form->createView(), 'formModal' => $formModal->createView(), 'formPermission' => $formPermission->createView(), 'groupe' => $groupe,  'choices' => $choices)); // On passe à Twig l'objet form et notre objet Groupe
    }   
    
    
    /**
    *  ADD a User to a Groupe
    * 
    */
    public function addUsersAction($groupeId)
    {
        $request = $this->get('request');

        $idUsers=$this->getRequest()->get('idUsers');
        //$idUsers = array ("u136227");        
        $groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId);
   
        /******2e formulaire en ARGUMENT*****/
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
        
        $formModal = $this->get('form.factory')->create(new SelectUserModalType(), $users);
     
        $options = $formModal->get('identifiant')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();       
        /************************************/     
        
        /******3e formulaire en ARGUMENT*****/       
        if($groupe->getPermission() == null)
        {
            $permission = new Permission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        else
        {
            $permission = $groupe->getPermission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        /************************************/              
        
        // Si le groupe soumet le formulaire
        //if ($request->getMethod() == 'POST') {
        if ('POST' == $request->getMethod()) {
            
           $formModal->submit($request->request->get($formModal->getName()));            
           //$formModal->handleRequest($request);
           //if ($formModal->isValid()) {
              
                $em = $this->getDoctrine()->getEntityManager();

                for($i = 0;$i < count($idUsers); $i++)
                {

                    $userManager = $this->get('fos_user.user_manager');
                    $user = $userManager->findUserBy(array('Identifiant' => $idUsers[$i]));

                    $groupe->addUtilisateurs($user);

                    $em->flush();
                }	
                
                $this->get('session')->getFlashBag()->set('notice',
                $this->get('translator')->trans('Utilisateur(s) ajouté(s) au groupe '.$groupe->getNom())
                );
                
                /*
                $json = array();
                $json['view1'] = $this->renderView('administration', array('groupeId' => $groupe->getId()));
                 
                $response = new Response(json_encode($json));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
                */
                
                return new RedirectResponse($this->generateUrl('administration', array(
                    'groupeId' => $groupe->getId()
                ))); 
            //}
        }

         return $this->render('NIPAUserBundle:Groupe:add.html.twig', array('form' => $form->createView(), 'formModal' => $formModal->createView(), 'formPermission' => $formPermission->createView(), 'groupe' => $groupe,  'choices' => $choices)); // On passe à Twig l'objet form et notre objet Groupe
    }
    
    public function deleteUsersAction($identifiant, $groupeId)
    {
        /********************************************************************/
        
        $groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId);

       /******1er formulaire de BASE********/
                
        // On vérifie que l'ID du groupe existe
        if (!$groupe) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This groupe does not exist.')
            );
        }
        
        // On bind le groupe récupéré depuis la BDD au formulaire pour modification
        $form = $this->get('form.factory')->create(new GroupeFormType(), $groupe);
        /************************************/

        /******2e formulaire en ARGUMENT*****/
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
        
        $formModal = $this->get('form.factory')->create(new SelectUserModalType(), $users);
     
        $options = $formModal->get('identifiant')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();          
        /************************************/
        
        /******3e formulaire en ARGUMENT*****/       
        if($groupe->getPermission() == null)
        {
            $permission = new Permission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        else
        {
            $permission = $groupe->getPermission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        /************************************/      
        
       /********************************************************************/
       
       
        // On efface un utilisateur d'un groupe
        $user = $userManager->findUserBy(array('Identifiant' => $identifiant)); // on accède aux service et on récupère les méthodes dans UserManager
        
        $em = $this->getDoctrine()->getManager();

        $groupe->removeUtilisateurs($user);

        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success','Utilisateur '.$user->getNom().' '.$user->getPrenom().' effacé');
        
        return $this->render('NIPAUserBundle:Groupe:add.html.twig', array('form' => $form->createView(), 'formModal' => $formModal->createView(), 'formPermission' => $formPermission->createView(), 'groupe' => $groupe,  'choices' => $choices)); // On passe à Twig l'objet form et notre objet Groupe
        
    }
    
    
    /**
    *  ADD Permission to a Groupe
    * 
    */
   public function addPermissionGroupeAction($groupeId)
   {
        $request = $this->get('request'); // On récupère l'objet request via le service container
        $groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId);

        $form = $this->get('form.factory')->create(new GroupeFormType(), $groupe); // On bind l'objet Groupe à notre formulaire GroupeFormType

        /******2e formulaire en ARGUMENT*****/
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
        
        // On bind le groupe récupéré depuis la BDD au formulaire pour modification
        $formModal = $this->get('form.factory')->create(new SelectUserModalType(), $users);
     
        $options = $formModal->get('identifiant')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();       
        /************************************/       
        
        /******3e formulaire en ARGUMENT*****/       
        if($groupe->getPermission() == null)
        {
            $permission = new Permission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        else
        {
            $permission = $groupe->getPermission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        /************************************/      
        
       if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
           //$form->bindRequest($request); // On bind les données du form DEPRECATED
           $formPermission->submit($request->request->get($formPermission->getName()));                       
            //$formPermission->handleRequest($request);
           //if ($formPermission->isValid()) { // Si le formulaire est valide

                // On lie les permissions au groupe
                $groupe->setPermission($permission);

                // On récupère l'EntityManager
                $em = $this->getDoctrine()->getManager();

                // On « persiste » l'entité
                $em->persist($groupe);
                
                // On déclenche l'enregistrement
                $em->flush();
                
                $this->get('session')->getFlashBag()->set('notice',
                $this->get('translator')->trans('Permissions au groupe ajouté')
                );
                
               // On redirige vers la page de modification du groupe
               return new RedirectResponse($this->generateUrl('groupe_edit', array(
                   'groupeId' => $groupe->getId()
               )));
           //}
       }
       
       return $this->render('NIPAUserBundle:Groupe:add.html.twig', array('form' => $form->createView(), 'formModal' => $formModal->createView(), 'formPermission' => $formPermission->createView(), 'groupe' => $groupe,  'choices' => $choices)); // On passe à Twig l'objet form et notre objet Groupe
   }
    
   /**
    *  EDIT Permission to a Groupe
    * 
    */
   public function editPermissionGroupeAction($groupeId)
   {
        $request = $this->get('request'); // On récupère l'objet request via le service container
        $groupe = $this->get('nipa_groupe.groupe_manager')->loadGroupe($groupeId);

        $form = $this->get('form.factory')->create(new GroupeFormType(), $groupe); // On bind l'objet Groupe à notre formulaire GroupeFormType

        /******2e formulaire en ARGUMENT*****/
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers(); // on accède aux service et on récupère les méthodes dans  UserManager
        
        // On bind le groupe récupéré depuis la BDD au formulaire pour modification
        $formModal = $this->get('form.factory')->create(new SelectUserModalType(), $users);
     
        $options = $formModal->get('identifiant')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();       
        /************************************/       
        
        /******3e formulaire en ARGUMENT*****/       
        if($groupe->getPermission() == null)
        {
            $permission = new Permission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        else
        {
            $permission = $groupe->getPermission();
            // On bind le groupe récupéré depuis la BDD au formulaire pour modification
            $formPermission = $this->get('form.factory')->create(new PermissionFormType(), $permission);
        }
        /************************************/      
        
       if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
           //$form->bindRequest($request); // On bind les données du form DEPRECATED
           $formPermission->submit($request->request->get($formPermission->getName()));                       
            //$formPermission->handleRequest($request);
           //if ($formPermission->isValid()) { // Si le formulaire est valide

                // On lie les permissions au groupe
                $groupe->setPermission($permission);

                // On récupère l'EntityManager
                $em = $this->getDoctrine()->getManager();

                // On « persiste » l'entité
                $em->persist($groupe);
                
                // On déclenche l'enregistrement
                $em->flush();
                
                $this->get('session')->getFlashBag()->set('notice',
                $this->get('translator')->trans('Permissions au groupe modifié')
                );
                
               // On redirige vers la page de modification du groupe
               return new RedirectResponse($this->generateUrl('groupe_edit', array(
                   'groupeId' => $groupe->getId()
               )));
           //}
       }
       
       return $this->render('NIPAUserBundle:Groupe:add.html.twig', array('form' => $form->createView(), 'formModal' => $formModal->createView(), 'formPermission' => $formPermission->createView(), 'groupe' => $groupe,  'choices' => $choices)); // On passe à Twig l'objet form et notre objet Groupe
   }
    
   
}