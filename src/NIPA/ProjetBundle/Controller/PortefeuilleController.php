<?php

namespace NIPA\ProjetBundle\Controller;

use NIPA\ProjetBundle\Form\Type\PortefeuilleFormType;
use NIPA\ProjetBundle\Form\Type\PortefeuilleBudgetPrevFormType;
use NIPA\ProjetBundle\Form\Type\PortefeuilleBudgetConsFormType;

use NIPA\ProjetBundle\Entity\Portefeuille;
use NIPA\ProjetBundle\Entity\PortefeuilleEnveloppePrev;
use NIPA\ProjetBundle\Entity\PortefeuilleEnveloppeCons;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\JsonResponse;
 
 
use Acme\BlogBundle\Form\Type\PostType;

class PortefeuilleController extends Controller
{
    public function indexAction()
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/
        
        $droit = 0;
        $user = $this->getUser();
    
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
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

        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll();         
       
        $portefeuille = new Portefeuille(); // On créé notre objet
        
        $form = $this->get('form.factory')->create(new PortefeuilleFormType(), $portefeuille); // On bind l'objet Groupe à notre formulaire GroupeFormType
    
       
        //return array();
        return $this->render('NIPAProjetBundle:Portefeuille:portefeuille.html.twig', array('user' => $user, 'form' => $form->createView(), 'portefeuille' => $portefeuille, 'listPortefeuille' => $listPortefeuille, 'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 'listPortefeuilleStatut' => $listPortefeuilleStatut)); // On passe à Twig l'objet form et notre objet
    } 
    
    /**
    *  ADD a Portefeuille
    * 
    */
    public function addPortefeuilleAction()    
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/        
        
        $droit = 0;
        $user = $this->getUser();
    
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
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
      
        $request = $this->get('request'); // On récupère l'objet request via le service container
        
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll();           
        /************************************/
        $portefeuille = new Portefeuille(); // On créé notre objet      
     
        $form = $this->get('form.factory')->create(new PortefeuilleFormType(), $portefeuille); // On bind l'objet à notre formulaire 

       /*************************************************/
        
        $entity = new PortefeuilleEnveloppePrev();
        
        $formPrev = $this->createForm(new PortefeuilleBudgetPrevFormType, $entity);

        //On récupère tous les enveloppes budgetaire PREV
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppePrev');
        $listPortefeuilleEnveloppePrev = $repository->findByPortefeuille($portefeuille);       
        
        // On trie les budgets prev dans l'ordre CHRONO
        $listTriEnveloppePrev = $listPortefeuilleEnveloppePrev;        
        usort($listTriEnveloppePrev, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /*************************************************/
          
        $entity2 = new PortefeuilleEnveloppeCons();
        
        $formCons = $this->createForm(new PortefeuilleBudgetConsFormType, $entity2);

        //On récupère tous les enveloppes budgetaire CONS
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppeCons');
        $listPortefeuilleEnveloppeCons = $repository->findByPortefeuille($portefeuille);        
        
        /*************************************************/       
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {                
        //if('POST' == $request->getMethod()) { // Si on a posté le formulaire
            //$form->submit($request->request->get($form->getName()));                       
           
           
                /*******************CALCUL de la référence*********************/
                //$number = $this->getDoctrine()->getManager()
                //        ->createQuery('Select count(p.referencePortefeuille) from NIPAProjetBundle:Portefeuille p Where p.referencePortefeuille LIKE :key')
                //        ->setParameter('key','%'.substr($portefeuille->getPortefeuilleAnnee()->getValeur(), -2).'%')
                //        ->getResult();
 
                $refs = $this->getDoctrine()->getManager()
                        ->createQuery('Select p.referencePortefeuille from NIPAProjetBundle:Portefeuille p Where p.referencePortefeuille LIKE :ipp')
                        ->setParameter('ipp','%'.substr($portefeuille->getPortefeuilleAnnee()->getValeur(), -2).'%')
                        ->getResult();        
                
                $indice = 0;
                for($i=0; $i<sizeof($refs); $i++)
                {
                    if(substr($refs[$i]["referencePortefeuille"], -1)>$indice)
                    {
                        $indice = substr($refs[$i]["referencePortefeuille"], -1);
                    }
                }
                
                if($indice < 9)
                {
                    $number_ref = $indice + 1;
                    $number_ref = '0'.$number_ref;
                }
                else
                {
                    $number_ref = $indice + 1;
                }
                
                $reference = 'PF-'.substr($portefeuille->getPortefeuilleAnnee()->getValeur(), -2).'-'.$number_ref;
                $portefeuille->setReferencePortefeuille($reference);
                /**************************************************************/
               
                /*******************CALCUL de l'IPP*********************/           
                $IPP = $portefeuille->getPortefeuilleEnveloppe()->getNom().' '.$portefeuille->getPortefeuilleAnnee()->getValeur();
                $portefeuille->setNom($IPP);
                /*******************************************************/
                
               //if ($form->isValid()) { // Si le formulaire est valide
                    
                    $this->get('nipa_portefeuille.portefeuille_manager')->savePortefeuille($portefeuille); // On utilise notre Manager pour gérer la sauvegarde de l'objet

                    $this->get('session')->getFlashBag()->set('success',
                    $this->get('translator')->trans('Portefeuille créé')
                    );

                     // On redirige vers la page de modification du portefeuille
                     return new RedirectResponse($this->generateUrl('portefeuille_edit', array(
                       'reference' => $portefeuille->getReferencePortefeuille()
                    )));
                     
                //}   
        }

        //return array();
        return $this->render('NIPAProjetBundle:Portefeuille:portefeuille.html.twig', array('user' => $user, 'form' => $form->createView(),'formPrev' => $formPrev->createView(), 'formCons' => $formCons->createView(), 'portefeuille' => $portefeuille, 'listPortefeuilleEnveloppePrev' => $listPortefeuilleEnveloppePrev,'listPortefeuilleEnveloppeCons' => $listPortefeuilleEnveloppeCons, 'listPortefeuille' => $listPortefeuille, 'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 'listPortefeuilleStatut' => $listPortefeuilleStatut, 'listTriEnveloppePrev' => $listTriEnveloppePrev)); // On passe à Twig l'objet form et notre objet

    }
    
    
    /**
    *  EDIT a Portefeuille
    * 
    */
    public function editPortefeuilleAction(Request $request, $reference)    
    {

        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/
        
        $droit = 0;
        $user = $this->getUser();
            
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
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
       
        // On vérifie que le portefeuille existe
        if(!$portefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadPortefeuille($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This portefeuille does not exist.')
            );
        }
        
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll();           
        /************************************/
        
        $form = $this->createForm(new PortefeuilleFormType(), $portefeuille);
       
       /*************************************************/
        
        $entity = new PortefeuilleEnveloppePrev();
        
        $formPrev = $this->createForm(new PortefeuilleBudgetPrevFormType, $entity);

        //On récupère tous les enveloppes budgetaire PREV
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppePrev');
        $listPortefeuilleEnveloppePrev = $repository->findByPortefeuille($portefeuille);       

        // On trie les budgets prev dans l'ordre CHRONO
        $listTriEnveloppePrev = $listPortefeuilleEnveloppePrev;        
        usort($listTriEnveloppePrev, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /*************************************************/
          
        $entity2 = new PortefeuilleEnveloppeCons();
        
        $formCons = $this->createForm(new PortefeuilleBudgetConsFormType, $entity2);

        //On récupère tous les enveloppes budgetaire CONS
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppeCons');
        $listPortefeuilleEnveloppeCons = $repository->findByPortefeuille($portefeuille);        
        
        /*************************************************/       
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {                
        //if('POST' == $request->getMethod()) { // Si on a posté le formulaire
            //$form->submit($request->request->get($form->getName()));                       
           
           //if ($form->isValid()) { // Si le formulaire est valide
                
                $portefeuille->setReferencePortefeuille($reference);
            
                /*******************CALCUL de l'IPP*********************/           
                $IPP = $portefeuille->getPortefeuilleEnveloppe()->getNom().' '.$portefeuille->getPortefeuilleAnnee()->getValeur();
                $portefeuille->setNom($IPP);
                /*******************************************************/
                        
                $this->get('nipa_portefeuille.portefeuille_manager')->savePortefeuille($portefeuille); // On utilise notre Manager pour gérer la sauvegarde de l'objet
                
                $this->get('session')->getFlashBag()->set('success',
                $this->get('translator')->trans('Portefeuille mis à jour')
                );
                
                 // On redirige vers la page de modification du portefeuille
                 return new RedirectResponse($this->generateUrl('portefeuille_edit', array(
                   'reference' => $portefeuille->getReferencePortefeuille()
                )));
            //}   
        
        }
        //return array();
        return $this->render('NIPAProjetBundle:Portefeuille:portefeuille.html.twig', array('user' => $user, 'form' => $form->createView(),'formPrev' => $formPrev->createView(), 'formCons' => $formCons->createView(), 'portefeuille' => $portefeuille, 'listPortefeuilleEnveloppePrev' => $listPortefeuilleEnveloppePrev,'listPortefeuilleEnveloppeCons' => $listPortefeuilleEnveloppeCons, 'listPortefeuille' => $listPortefeuille, 'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 'listPortefeuilleStatut' => $listPortefeuilleStatut, 'listTriEnveloppePrev' => $listTriEnveloppePrev)); // On passe à Twig l'objet form et notre objet

    }  

    public function deletePortefeuilleAction($reference)
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/        
        
        // On vérifie que le portefeuille existe
        if(!$portefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadPortefeuille($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This portefeuille does not exist.')
            );
        }
        
        $em = $this->getDoctrine()->getEntityManager();

        //On récupère tous les enveloppes budgetaire PREV        
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppePrev');
        $listPortefeuilleEnveloppePrev = $repository->findByPortefeuille($portefeuille);           

        //On récupère tous les enveloppes budgetaire CONS
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppeCons');
        $listPortefeuilleEnveloppeCons = $repository->findByPortefeuille($portefeuille); 
        
        // On supprime AVANT les éléments des tables où le portefeuille (id) est une clé étrangère
        foreach($listPortefeuilleEnveloppePrev as $prev)
        {
            $em->remove($prev);
        }
        foreach($listPortefeuilleEnveloppeCons as $cons)
        {
            $em->remove($cons);
        }
        $em->flush();

        // On peut maintenant supprimer le portefeuille même
        $this->get('nipa_portefeuille.portefeuille_manager')->deletePortefeuille($portefeuille);     
        
        $this->get('session')->getFlashBag()->add('success','Suppression effectuée');  
        return new RedirectResponse($this->generateUrl('portefeuille'));                     
    }    
    
    /**
    *  EDIT budget prev of a Portefeuille
    * 
    */
    public function editBudgetPrevAction($reference)    
    {
        
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/        
        
        $droit = 0;
        $user = $this->getUser();
                
        $request = $this->get('request');
        
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
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
        
        // On vérifie que le portefeuille existe
        if(!$portefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadPortefeuille($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This portefeuille does not exist.')
            );
        }
        $form = $this->createForm(new PortefeuilleFormType(), $portefeuille);
        
       /*************************************************/
        
        $entity = new PortefeuilleEnveloppePrev();
        
        $formPrev = $this->createForm(new PortefeuilleBudgetPrevFormType, $entity);

        //On récupère tous les enveloppes budgetaire PREV
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppePrev');
        $listPortefeuilleEnveloppePrev = $repository->findByPortefeuille($portefeuille);       
        
        // On trie les budgets prev dans l'ordre CHRONO
        $listTriEnveloppePrev = $listPortefeuilleEnveloppePrev;        
        usort($listTriEnveloppePrev, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /*************************************************/
          
        $entity2 = new PortefeuilleEnveloppeCons();
        
        $formCons = $this->createForm(new PortefeuilleBudgetConsFormType, $entity2);

        //On récupère tous les enveloppes budgetaire CONS
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppeCons');
        $listPortefeuilleEnveloppeCons = $repository->findByPortefeuille($portefeuille);        
        
        /*************************************************/  
        
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll();           
        /************************************/        
        
        if ($request->isXmlHttpRequest()) {
            //return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 200);
            
            $formPrev->handleRequest($request);
            if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
                
                //$data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);

                $nom= $request->request->get('type');
                $var=$this->getRequest()->request->get('date');
                $date = str_replace('/', '-', $var);
                $format = date('Y-m-d', strtotime($date));     
                $time = new \DateTime($format);
               
                $montant=$this->getRequest()->request->get('montant');
                $commentaire=$this->getRequest()->request->get('comment');

                $entity->setNom($nom);
                $entity->setDate($time);
                $entity->setMontant($montant);
                $entity->setCommentaires($commentaire);
                $entity->setPortefeuille($portefeuille);

                /*$entity->setNom("test");
                $time = new \DateTime('2013-03-11');
                $entity->setDate($time);
                $entity->setMontant(11111);
                $entity->setCommentaires("zksjzkjszkjskzjskjzk");
                $entity->setPortefeuille($portefeuille);*/

                //if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('success','Mise à jour budget prév. effectuée');  
 
                    return new JsonResponse(array('message' => 'Success!'), 200);
                //}

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response;   
            }
        }
        
        //return array();
        return $this->render('NIPAProjetBundle:Portefeuille:portefeuille.html.twig', array('user' => $user, 'form' => $form->createView(),'formPrev' => $formPrev->createView(), 'formCons' => $formCons->createView(), 'portefeuille' => $portefeuille, 'listPortefeuilleEnveloppePrev' => $listPortefeuilleEnveloppePrev,'listPortefeuilleEnveloppeCons' => $listPortefeuilleEnveloppeCons, 'listPortefeuille' => $listPortefeuille, 'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 'listPortefeuilleStatut' => $listPortefeuilleStatut, 'listTriEnveloppePrev' => $listTriEnveloppePrev)); // On passe à Twig l'objet form et notre objet

    }      

   /**
    *  EDIT budget cons of a Portefeuille
    * 
    */
    public function editBudgetConsAction($reference)    
    {
      
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/        
        
        $droit = 0;
        $user = $this->getUser();
                
        $request = $this->get('request');
        
        foreach($user->getGroupesToArray() as $groupe) // Pour chaque Groupe affilié au user
        {
            if($groupe->getPermission() != null) // Test si le groupe a des permissions
            {
                if(($groupe->getPermission()->getCMSPortefeuille() == 1) || ($groupe->getPermission()->getLPortefeuille() == 1)) // Si oui on test les droits d'accès
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
        
        // On vérifie que le portefeuille existe
        if(!$portefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadPortefeuille($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This portefeuille does not exist.')
            );
        }
        $form = $this->createForm(new PortefeuilleFormType(), $portefeuille);
        
        /*************************************************/
        
        $entity = new PortefeuilleEnveloppePrev();
        
        $formPrev = $this->createForm(new PortefeuilleBudgetPrevFormType, $entity);

        //On récupère tous les enveloppes budgetaire PREV
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppePrev');
        $listPortefeuilleEnveloppePrev = $repository->findByPortefeuille($portefeuille);       

        // On trie les budgets prev dans l'ordre CHRONO
        $listTriEnveloppePrev = $listPortefeuilleEnveloppePrev;        
        usort($listTriEnveloppePrev, function($a, $b) {
          return ($a->getDate() < $b->getDate()) ? -1 : 1;
        });
        /*************************************************/
          
        $entity2 = new PortefeuilleEnveloppeCons();
        
        $formCons = $this->createForm(new PortefeuilleBudgetConsFormType, $entity2);

        //On récupère tous les enveloppes budgetaire CONS
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppeCons');
        $listPortefeuilleEnveloppeCons = $repository->findByPortefeuille($portefeuille);        
        
        /*************************************************/        

        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        //On récupère tous les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll();           
        /************************************/  
             
        if ($request->isXmlHttpRequest()) {
            //return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 200);
            
            $formCons->handleRequest($request);
            if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
                
                //$data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);
                
                $m_mensuel=$this->getRequest()->get('champ1');
                $m_cumul=$this->getRequest()->get('champ2');
                $commentaires=$this->getRequest()->get('champ3');

                $em = $this->getDoctrine()->getManager();
                //if ($form->isValid()) {

                    for($i = 0;$i < count($m_mensuel); $i++)
                    {
                        // Mise au bon format DATE
                        $time = new \DateTime($portefeuille->getPortefeuilleAnnee()->getValeur().'-'.($i+1).'-01');

                        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppeCons');
                        // On test si le row existe deja ou non dans la bd
                        if($entity2 = $repository->findOneBy(array('portefeuille' => $portefeuille, 'date' => $time))){
                        }else{
                            $entity2 = new PortefeuilleEnveloppeCons();                           
                        }
                        
                        $entity2->setDate($time);
                        $entity2->setMontantMensuel($m_mensuel[$i]);
                        //Calcul du cumul cons
                        if($i == 0)
                        {
                            $m_cumul[$i] = $m_mensuel[$i];
                        }
                        else
                        {
                            $m_cumul[$i] = $m_mensuel[$i] + $m_cumul[$i-1];
                        }
                        $entity2->setMontantCumul($m_cumul[$i]);
                        
                        $entity2->setCommentaires($commentaires[$i]);
                        $entity2->setPortefeuille($portefeuille);
                        //\Doctrine\Common\Util\Debug::dump($entity2);
                        $em->persist($entity2);

                        $em->flush();
                    }
                    
                    $this->get('session')->getFlashBag()->add('success','Mise à jour budget cons. effectuée');  

                    //return new JsonResponse(array('message' => 'Success!'), 200);
                    return new JsonResponse(array('message' => 'Success!'), 200);
                   
                //}

                $response = new JsonResponse(array('message' => 'Error'), 400);
                return $response;               
            }
        }
        
        //return array();
        return $this->render('NIPAProjetBundle:Portefeuille:portefeuille.html.twig', array('user' => $user, 'form' => $form->createView(),'formPrev' => $formPrev->createView(), 'formCons' => $formCons->createView(), 'portefeuille' => $portefeuille, 'listPortefeuilleEnveloppePrev' => $listPortefeuilleEnveloppePrev,'listPortefeuilleEnveloppeCons' => $listPortefeuilleEnveloppeCons, 'listPortefeuille' => $listPortefeuille, 'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 'listPortefeuilleStatut' => $listPortefeuilleStatut, 'listTriEnveloppePrev' => $listTriEnveloppePrev)); // On passe à Twig l'objet form et notre objet

    }      

    public function deleteBudgetPrevAction($id)
    {
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
               
        if ($droit == "denied") { // On test si user pour avoir accès à la section 
            //throw new AccessDeniedException("Section autorisée uniquement pour les administrateurs!");
            $this->get('session')->getFlashBag()->set('error', "Vous n'avez pas les droits requis pour accéder à cette section!");            
        }        
        /***********************************************************/        
        
        //On récupère tous les enveloppes budgetaire PREV
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppePrev');
        $PortefeuilleEnveloppePrev = $repository->findOneBy(array('id' => $id)); 
        
        $reference = $PortefeuilleEnveloppePrev->getPortefeuille()->getReferencePortefeuille();
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($PortefeuilleEnveloppePrev);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success','Suppression effectuée');  
        
        return new RedirectResponse($this->generateUrl('portefeuille_edit', array(
          'reference' => $reference
                
       )));                     
    }    
    
}