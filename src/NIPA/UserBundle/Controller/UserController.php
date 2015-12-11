<?php

namespace NIPA\UserBundle\Controller;

use NIPA\UserBundle\Form\Type\UserType;
use NIPA\UserBundle\Entity\Utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
	
    /**
    * @Route("/", name="user")
    * @Template()
    */
    public function indexAction()
    {
         /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/  
        
        //return array();
	return $this->render('NIPAUserBundle:User:user.html.twig', array());
    }
    
    /**
    * @Route("/show2/{userId}", name="user_show")
    * @Template()
    */
   public function showAction($userId)
   {
         /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/         
       
       if (!$user = $this->get('nipa_user.user_manager')->loadUser($userId)) // on accède aux service et on récupère les méthodes dans  UserManager
       {
           throw new NotFoundHttpException($this->get('translator')->trans('This user does not exist.'));
       }

       return array('user' => $user);
   }  
  
   /*
    public function newAction(Request $request)
    {
        // On initialise notre objet Utilisateur
        $user = new Utilisateur();

        // On créé l'objet form à partir du formBuilder (En passant en param l'objet Utilisateur)
        $form = $this->createFormBuilder($user)
            ->add('Identifiant', 'text') // On ajoute le champ Identifiant dans un input text
            ->add('Prenom', 'text') // On ajoute le champ Prenom dans un input text
            ->add('Nom', 'text') // On ajoute le champ Nom dans un input text
            ->add('Email', 'text') // On ajoute le champ Email dans un input text
            ->add('Password', 'text') // On ajoute le champ Password dans un input text
            ->add('Admin', 'checkbox') // Idem pour le résumé mais dans un champ textarea
            ->getForm(); // On récupère l'objet form 

        if ($request->getMethod() == 'POST') { // Si on a soumis le formulaire
            $form->bindRequest($request); // On bind les valeurs du POST à notre formulaire

            if ($form->isValid()) { // On teste si les données entrées dans notre formulaire sont valides

                // On sauvegarde, redirige etc.

            }
        }
    }
    * 
    */
   
    /**
    * @Route("/add", name="user_add")
    * @Template()
    */
   public function addAction()
   {
         /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/  
        
       $request = $this->get('request'); // On récupère l'objet request via le service container
       $user = new Utilisateur(); // On créé notre objet Utilisateur vierge

       $form = $this->get('form.factory')->create(new UserType(), $user); // On bind l'objet Utilisateur à notre formulaire UserType

	   //$user.setRoles(array('ROLE_USER'));
	   
       if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
           $form->bindRequest($request); // On bind les données du form
           if ($form->isValid()) { // Si le formulaire est valide

               $this->get('nipa_user.user_manager')->saveUser($user); // On utilise notre Manager pour gérer la sauvegarde de l'objet

               // On envoi une 'flash' pour indiquer à l'utilisateur que le user est ajouté
               $this->get('session')->setFlash('notice', 
                   $this->get('translator')->trans('User added')
               );

               // On redirige vers la page de modification du bureau
               return new RedirectResponse($this->generateUrl('user_edit', array(
                   'userId' => $user->getId()
               )));
           }
       }

       return array('form' => $form->createView(), 'user' => $user); // On passe à Twig l'objet form et notre objet Utilisateur
   }
   
    /**
    * @Route("/edit/{userId}", name="user_edit")
    */
    public function editAction($userId)
    {
         /**********************DROIT SECTION************************/
        $requestDroit = Request::createFromGlobals();
        $droit = $requestDroit->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/  
        
        $request = $this->get('request');
        
        // On vérifie que l'ID de l'utilisateur existe
        if (!$user = $this->get('nipa_user.user_manager')->loadUser($userId)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This user does not exist.')
            );
        }
        
        // On bind l'utilisateur récupéré depuis la BDD au formulaire pour modification
        $form = $this->get('form.factory')->create(new UserType(), $user);
        
        // Si l'utilisateur soumet le formulaire
		//if ($request->getMethod() == 'POST') {
		if ('POST' == $request->getMethod()) {
            //$form->bindRequest($request); //DEPRECATED
			//$form->bind($this->$request);
			$form->handleRequest($request);
            if ($form->isValid()) {
                
                $this->get('nipa_user.user_manager')->saveUser($user);
                
                //DEPRECATED
                //$this->get('session')->setFlash('notice',
                //    $this->get('translator')->trans('User updated.')
                //);
				
                    $this->get('session')->getFlashBag()->set('notice',
                    $this->get('translator')->trans('User updated.')
                );
				
                return new RedirectResponse($this->generateUrl('user_edit', array(
                    'userId' => $user->getId()
                )));
            }
        }

        return $this->render('NIPAUserBundle:User:add.html.twig',array('form' => $form->createView(), 'user' => $user)); // On change le template par défaut et on réutilise celui de add qui est le même
    }   

}