<?php

namespace NIPA\ProjetBundle\Controller;

use NIPA\ProjetBundle\Form\Type\ProjetFormType;
use NIPA\ProjetBundle\Form\Type\ProjetEnCadrageFormType;
use NIPA\ProjetBundle\Form\Type\ProjetEnConceptionFormType;
use NIPA\ProjetBundle\Form\Type\ProjetEnRealisationFormType;

use NIPA\ProjetBundle\Entity\Projet;
use NIPA\ProjetBundle\Entity\ProjetEtape;
use NIPA\ProjetBundle\Entity\ProjetListeLivrable;
use NIPA\ProjetBundle\Entity\ProjetListeInstance;
use NIPA\ProjetBundle\Entity\ProjetListeJalonDate;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class ProjetController extends Controller
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
                if(($groupe->getPermission()->getCMSProjet() == 1) || ($groupe->getPermission()->getLProjet() == 1)) // Si oui on test les droits d'accès
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
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });   
        
        
        /************************************/
        
        //return array() List Phases en etape CADRAGE
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeCadrage = $repository->findByrefEtape("1");     
        //On trie la liste
        usort($listProjetPhaseEtapeCadrage, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });   
      
        //return array() List Phases en etape CONCEPTION
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeConception = $repository->findByrefEtape("2");     
        //On trie la liste
        usort($listProjetPhaseEtapeConception, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Etapes en etape REALISATION
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeRealisation = $repository->findByrefEtape("3");     
        //On trie la liste
        usort($listProjetPhaseEtapeRealisation, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Livrables
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetLivrable');
        $listProjetLivrable = $repository->findAll();  
        //On trie la liste 
        usort($listProjetLivrable, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });    

        //return array() List Jalons Date
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetJalonDate');
        $listProjetJalonDate = $repository->findAll();  
        //On trie la liste 
        usort($listProjetJalonDate, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Instances
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
        $listProjetInstance = $repository->findByType("Projet");  
        //On trie la liste 
        usort($listProjetInstance, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        }); 
        
        /************************************/

        //On récupère les interlocuteurMOA
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInterlocuteurMOA');
        $listInterlocuteurMOA = $repository->findAll();     
        //On récupère les Porteurs Metiers
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePorteurMetier');
        $listPorteurMetier = $repository->findAll();         
         //On récupère les SDM
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeSDM');
        $listSDM = $repository->findAll(); 
        
        /************************************/

        // Form En Cadrage
        $projetEnCadrage = new ProjetEtape();
        $formEnCadrage = $this->get('form.factory')->create(new ProjetEnCadrageFormType(), $projetEnCadrage);

        // Form En Conception
        $projetEnConception = new ProjetEtape();
        $formEnConception = $this->get('form.factory')->create(new ProjetEnConceptionFormType(), $projetEnConception);
        
        // Form En Réalisation
        $projetEnRealisation = new ProjetEtape();
        $formEnRealisation = $this->get('form.factory')->create(new ProjetEnRealisationFormType(), $projetEnRealisation);
                
        /************************************/
        
        $projet = new Projet(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new ProjetFormType(), $projet); // On bind l'objet à notre formulaire 
        
        /*************************************************/     
       
        //return array();
        return $this->render('NIPAProjetBundle:Projet:projet.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(),
            'formEnCadrage' => $formEnCadrage->createView(),
            'formEnConception' => $formEnConception->createView(),
            'formEnRealisation' => $formEnRealisation->createView(),
            'projet' => $projet, 
            'listDemande' => $listDemande,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut,
            'listInterlocuteurMOA' => $listInterlocuteurMOA,
            'listPorteurMetier' => $listPorteurMetier,
            'listSDM' => $listSDM,
            'listProjetPhaseEtapeCadrage' => $listProjetPhaseEtapeCadrage,
            'listProjetPhaseEtapeConception' => $listProjetPhaseEtapeConception,
            'listProjetPhaseEtapeRealisation' => $listProjetPhaseEtapeRealisation,
            'listProjetLivrable' => $listProjetLivrable,
            'listProjetJalonDate' => $listProjetJalonDate,
            'listProjetInstance' => $listProjetInstance
            )); 
    } 
    
    
    
    /**
    *  ADD a Projet
    * 
    */
    public function addProjetAction()
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
                if(($groupe->getPermission()->getCMSProjet() == 1) || ($groupe->getPermission()->getLProjet() == 1)) // Si oui on test les droits d'accès
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
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });   
        
        /************************************/

        //return array() List Phases en etape CADRAGE
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeCadrage = $repository->findByrefEtape("1");     
        //On trie la liste
        usort($listProjetPhaseEtapeCadrage, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });   
      
        //return array() List Phases en etape CONCEPTION
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeConception = $repository->findByrefEtape("2");     
        //On trie la liste
        usort($listProjetPhaseEtapeConception, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Etapes en etape REALISATION
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeRealisation = $repository->findByrefEtape("3");     
        //On trie la liste
        usort($listProjetPhaseEtapeRealisation, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Livrables
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetLivrable');
        $listProjetLivrable = $repository->findAll();  
        //On trie la liste 
        usort($listProjetLivrable, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });   
        
        //return array() List Jalons Date
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetJalonDate');
        $listProjetJalonDate = $repository->findAll();  
        //On trie la liste 
        usort($listProjetJalonDate, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Instances
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
        $listProjetInstance = $repository->findByType("Projet");  
        //On trie la liste 
        usort($listProjetInstance, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });         
        
        /************************************/        
        //On récupère les interlocuteurMOA
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInterlocuteurMOA');
        $listInterlocuteurMOA = $repository->findAll();     
        //On récupère les Porteurs Metiers
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePorteurMetier');
        $listPorteurMetier = $repository->findAll();         
         //On récupère les SDM
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeSDM');
        $listSDM = $repository->findAll(); 
        
        /************************************/

        // Form En Cadrage
        $projetEnCadrage = new ProjetEtape();
        $formEnCadrage = $this->get('form.factory')->create(new ProjetEnCadrageFormType(), $projetEnCadrage);

        // Form En Conception
        $projetEnConception = new ProjetEtape();
        $formEnConception = $this->get('form.factory')->create(new ProjetEnConceptionFormType(), $projetEnConception);
        
        // Form En Réalisation
        $projetEnRealisation = new ProjetEtape();
        $formEnRealisation = $this->get('form.factory')->create(new ProjetEnRealisationFormType(), $projetEnRealisation);
                
        /************************************/        
        
        $projet = new Projet(); // On créé notre objet      
        $form = $this->get('form.factory')->create(new ProjetFormType(), $projet); // On bind l'objet à notre formulaire 
        
        /*************************************************/     
       
        $form->handleRequest($request);
        if($form->isSubmitted()) {                                   
            
            $em = $this->getDoctrine()->getEntityManager();

            $data = $request->request->all();
            $refDemande = $data["referenceDemande"];
            $interlocuteurMOA = $data["interlocuteurMOA"];
            $porteurMetier = $data["porteurMetier"];
            $SDM = $data["SDM"];
            $demande = $this->get('nipa_demande.demande_manager')->loadDemande($refDemande);
            //\Doctrine\Common\Util\Debug::dump($data);                

            if($data["nipa_projet_projet"]["lotissement"] == 0) // SI pas de lotissement
            {
                // On récupère la liste des projets de cette demande
                $listProjets = $em->getRepository('NIPAProjetBundle:Projet')->findBy(array('demande' => $demande));
                
                if(sizeof($listProjets) == 0)
                {
                    $refProjet = $refDemande.'-1';
                }
                else
                {
                    // SI pas de lotissement de base mais on trouve un projet quand même on lotie le projet alors
                    $projet->setLotissement(true);
                    $number = sizeof($listProjets)+1;
                    $refProjet = $refDemande.'-'.$number;
                }                
            }
            else // Si lotissement
            {
                // On récupère la liste des projets de cette demande
                $listProjets = $em->getRepository('NIPAProjetBundle:Projet')->findBy(array('demande' => $demande));
                
                if(sizeof($listProjets) == 0)
                {
                    $refProjet = $refDemande.'-1';
                }
                else
                {
                    $number = sizeof($listProjets)+1;
                    $refProjet = $refDemande.'-'.$number;
                }
            }
            
            $projet->setReferenceProjet($refProjet);
            $projet->setInterlocuteurMOA($interlocuteurMOA);
            $projet->setPorteurMetier($porteurMetier);
            $projet->setSDM($SDM);
            /**************************************************************/

            //if ($form->isValid()) { // Si le formulaire est valide              

                // On add le projet à la demande selectionné
                $projet->setDemande($demande);

                $this->get('nipa_projet.projet_manager')->saveProjet($projet); // On utilise notre Manager pour gérer la sauvegarde de l'objet

                $em->flush();                    

                $this->get('session')->getFlashBag()->set('success',
                $this->get('translator')->trans('Projet créé')
                );

                 // On redirige vers la page de modification du projet
                 return new RedirectResponse($this->generateUrl('projet_edit', array(
                   'reference' => $projet->getReferenceProjet()
                )));

            //}   
        }        
        
        
        //return array();
        return $this->render('NIPAProjetBundle:Projet:projet.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(),
            'formEnCadrage' => $formEnCadrage->createView(),
            'formEnConception' => $formEnConception->createView(),
            'formEnRealisation' => $formEnRealisation->createView(),
            'projet' => $projet, 
            'listDemande' => $listDemande,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut,
            'listInterlocuteurMOA' => $listInterlocuteurMOA,
            'listPorteurMetier' => $listPorteurMetier,
            'listSDM' => $listSDM,
            'listProjetPhaseEtapeCadrage' => $listProjetPhaseEtapeCadrage,
            'listProjetPhaseEtapeConception' => $listProjetPhaseEtapeConception,
            'listProjetPhaseEtapeRealisation' => $listProjetPhaseEtapeRealisation,
            'listProjetLivrable' => $listProjetLivrable,
            'listProjetJalonDate' => $listProjetJalonDate,
            'listProjetInstance' => $listProjetInstance
            )); 
    } 
    
    
    /**
    *  ADD a Projet
    * 
    */
    public function editProjetAction($reference)
    {
        
        /**********************DROIT SECTION************************/
        $requests = Request::createFromGlobals();
        $droit = $requests->query->get('droit');
        $request = $this->get('request');

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
                if(($groupe->getPermission()->getCMSProjet() == 1) || ($groupe->getPermission()->getLProjet() == 1)) // Si oui on test les droits d'accès
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
        
        // On vérifie que l'objet existe
        if(!$projet = $this->get('nipa_projet.projet_manager')->loadProjet($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This projet does not exist.')
            );
        }
        
        /***************DATA TREE*******************/
        //return array() List ALL Portefeuille;
        $listPortefeuille = $this->get('nipa_portefeuille.portefeuille_manager')->loadAllPortefeuille();
        //On trie la liste des portefeuilles
        usort($listPortefeuille, function ($a, $b) {
            return strnatcmp($a->getReferencePortefeuille(), $b->getReferencePortefeuille());
        });        
        
        //On récupère toutes les enveloppes
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleEnveloppe');
        $listPortefeuilleEnveloppe = $repository->findAll();     
        //On récupère toutes les années
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleAnnee');
        $listPortefeuilleAnnee = $repository->findAll();         
         //On récupère tous les status
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:PortefeuilleStatut');
        $listPortefeuilleStatut = $repository->findAll(); 
        
        //return array() List ALL Demandes;
        $listDemande = $this->get('nipa_demande.demande_manager')->loadAllDemande();
        //On trie la liste des demandes
        usort($listDemande, function ($a, $b) {
            return strnatcmp($a->getReferenceDemande(), $b->getReferenceDemande());
        });   
        
        /************************************/

        //return array() List Phases en etape CADRAGE
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeCadrage = $repository->findByrefEtape("1");     
        //On trie la liste
        usort($listProjetPhaseEtapeCadrage, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });   
      
        //return array() List Phases en etape CONCEPTION
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeConception = $repository->findByrefEtape("2");     
        //On trie la liste
        usort($listProjetPhaseEtapeConception, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Etapes en etape REALISATION
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetPhase');
        $listProjetPhaseEtapeRealisation = $repository->findByrefEtape("3");     
        //On trie la liste
        usort($listProjetPhaseEtapeRealisation, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Livrables
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetLivrable');
        $listProjetLivrable = $repository->findAll();  
        //On trie la liste 
        usort($listProjetLivrable, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Jalons Date
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetJalonDate');
        $listProjetJalonDate = $repository->findAll();  
        //On trie la liste 
        usort($listProjetJalonDate, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        });
        
        //return array() List Instances
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInstance');
        $listProjetInstance = $repository->findByType("Projet");  
        //On trie la liste 
        usort($listProjetInstance, function ($a, $b) {
            return strnatcmp($a->getReference(), $b->getReference());
        }); 
        
        /************************************/
        //On récupère les interlocuteurMOA
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeInterlocuteurMOA');
        $listInterlocuteurMOA = $repository->findAll();     
        //On récupère les Porteurs Metiers
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandePorteurMetier');
        $listPorteurMetier = $repository->findAll();         
         //On récupère les SDM
        $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:DemandeSDM');
        $listSDM = $repository->findAll(); 
        
        /************************************/
        
        // Form En Cadrage
        $projetEnCadrage = new ProjetEtape();
        $formEnCadrage = $this->get('form.factory')->create(new ProjetEnCadrageFormType(), $projetEnCadrage);

        // Form En Conception
        $projetEnConception = new ProjetEtape();
        $formEnConception = $this->get('form.factory')->create(new ProjetEnConceptionFormType(), $projetEnConception);
        
        // Form En Réalisation
        $projetEnRealisation = new ProjetEtape();
        $formEnRealisation = $this->get('form.factory')->create(new ProjetEnRealisationFormType(), $projetEnRealisation);
                
        /************************************/
        
        $form = $this->get('form.factory')->create(new ProjetFormType(), $projet); // On bind l'objet à notre formulaire 
        
        /*************************************************/     
       
        $form->handleRequest($request);
        if($form->isSubmitted()) {                                   
   
            $data = $request->request->all();
            $refDemande = $data["referenceDemande"];
            $interlocuteurMOA = $data["interlocuteurMOA"];
            $porteurMetier = $data["porteurMetier"];
            $SDM = $data["SDM"];
            $demande = $this->get('nipa_demande.demande_manager')->loadDemande($refDemande);
            //\Doctrine\Common\Util\Debug::dump($data);                

            if($data["nipa_projet_projet"]["lotissement"] == 0) // SI pas de lotissement
            {
                
            }
            else // Si lotissement
            {
                
            }
            
            $projet->setReferenceProjet($reference);
            $projet->setInterlocuteurMOA($interlocuteurMOA);
            $projet->setPorteurMetier($porteurMetier);
            $projet->setSDM($SDM);
            /**************************************************************/

            //if ($form->isValid()) { // Si le formulaire est valide              
                $em = $this->getDoctrine()->getEntityManager();

                // On add le projet à la demande selectionné
                $projet->setDemande($demande);

                $this->get('nipa_projet.projet_manager')->saveProjet($projet); // On utilise notre Manager pour gérer la sauvegarde de l'objet

                $em->flush();                    

                $this->get('session')->getFlashBag()->set('success',
                $this->get('translator')->trans('Projet mis à jour')
                );

                 // On redirige vers la page de modification du projet
                 return new RedirectResponse($this->generateUrl('projet_edit', array(
                   'reference' => $projet->getReferenceProjet()
                )));

            //}   
        }        
        
        
        //return array();
        return $this->render('NIPAProjetBundle:Projet:projet.html.twig', array(
            'user' => $user, 
            'form' => $form->createView(),
            'formEnCadrage' => $formEnCadrage->createView(),
            'formEnConception' => $formEnConception->createView(),
            'formEnRealisation' => $formEnRealisation->createView(),
            'projet' => $projet, 
            'listDemande' => $listDemande,
            'listPortefeuille' => $listPortefeuille, 
            'listPortefeuilleEnveloppe' => $listPortefeuilleEnveloppe, 
            'listPortefeuilleAnnee' => $listPortefeuilleAnnee, 
            'listPortefeuilleStatut' => $listPortefeuilleStatut,
            'listInterlocuteurMOA' => $listInterlocuteurMOA,
            'listPorteurMetier' => $listPorteurMetier,
            'listSDM' => $listSDM,
            'listProjetPhaseEtapeCadrage' => $listProjetPhaseEtapeCadrage,
            'listProjetPhaseEtapeConception' => $listProjetPhaseEtapeConception,
            'listProjetPhaseEtapeRealisation' => $listProjetPhaseEtapeRealisation,
            'listProjetLivrable' => $listProjetLivrable,
            'listProjetJalonDate' => $listProjetJalonDate,
            'listProjetInstance' => $listProjetInstance
            )); 
    }     
  
    /**
    *  Delete a Projet
    * 
    */
    public function deleteProjetAction()    
    {
        
    }    
    
    /**
    *  SELECT INFO Projet with a Demande
    * 
    */
    public function loadProjetDemandeAction()    
    {
   
        $request = $this->get('request');
        
        if ($request->isXmlHttpRequest()) {
            //return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 200);
 
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);

                $referenceDemande=$data["referenceDemande"];

                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:Demande');            
                $demande = $repository->findOneBy(array('referenceDemande' => $referenceDemande));
                
                // TESTs NULL
                if($demande->getNom() == null)
                {
                    $titre = "";
                }
                else
                {
                    $titre = $demande->getNom();
                }
                if($demande->getTypeEnveloppe() == null)
                {
                    $TypeEnveloppe = "";
                }
                else
                {
                    $TypeEnveloppe = $demande->getTypeEnveloppe();
                }
                if($demande->getPriorite() == null)
                {
                    $priorite = "";
                }
                else
                {
                    $priorite = $demande->getPriorite()->getNom();
                }
                if($demande->getDirection() == null)
                {
                    $direction = "";
                }
                else
                {
                    $direction = $demande->getDirection()->getNom();
                }
                if($demande->getEntiteMetier() == null)
                {
                    $EntiteMetier = "";
                }
                else
                {
                    $EntiteMetier = $demande->getEntiteMetier()->getNom();
                }
                if($demande->getOffres() == null)
                {
                    $offres = "";
                }
                else
                {
                    $offres = $demande->getOffres()->getNom();
                }                
                if($demande->getTypeProjet() == null)
                {
                    $TypeProjet = "";
                }
                else
                {
                    $TypeProjet = $demande->getTypeProjet()->getNom();
                }
                if($demande->getInterlocuteurMOA() == null)
                {
                    $InterlocuteurMOA = "";
                }
                else
                {
                    $InterlocuteurMOA = $demande->getInterlocuteurMOA()->getNom();
                }
                if($demande->getPorteurMetier() == null)
                {
                    $PorteurMetier = "";
                }
                else
                {
                    $PorteurMetier = $demande->getPorteurMetier()->getNom();
                }
                if($demande->getSDM() == null)
                {
                    $SDM = "";
                }
                else
                {
                    $SDM = $demande->getSDM()->getNom();
                }
                
                return new JsonResponse(array(
                    'titre' => $titre,
                    'typeEnveloppe' => $TypeEnveloppe,
                    'priorite' => $priorite,
                    'direction' => $direction,
                    'entiteMetier' => $EntiteMetier,
                    'offres' => $offres,
                    'typeProjet' => $TypeProjet,
                    'interlocuteurMOA' => $InterlocuteurMOA,
                    'porteurMetier' => $PorteurMetier,
                    'SDM' => $SDM 
                    ));

        }
            
        return new Response("Erreur requête...");     
    }    
 
    /**
    *  UPDATE TTD (JALON+LIVRABLES) En Réalisation of a Projet
    * 
    */
    public function updateEnRealisationAction($reference)    
    {
   
        $request = $this->get('request');
            
        // On vérifie que l'objet existe
        if(!$projet = $this->get('nipa_projet.projet_manager')->loadProjet($reference)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This projet does not exist.')
            );
        }
        
        /***************************************************************/        

          // Form En Réalisation
        $projetEnRealisation = new ProjetEtape;
        $formEnRealisation = $this->get('form.factory')->create(new ProjetEnRealisationFormType(), $projetEnRealisation);
         
        /***************************************************************/        
        
        if ($request->isXmlHttpRequest()) {
            //return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 200);

            $formEnRealisation->handleRequest($request);
            if ('POST' == $request->getMethod()) { // Si on a posté le formulaire
                
                $data = $request->request->all();
                //\Doctrine\Common\Util\Debug::dump($data);

                //\Doctrine\Common\Util\Debug::dump($data["Livrable"]["id"]);
                //\Doctrine\Common\Util\Debug::dump($data["Livrable"]["datePrev"]);
                //\Doctrine\Common\Util\Debug::dump($data["Livrable"]["dateRev"]);
                //\Doctrine\Common\Util\Debug::dump($data["Livrable"]["validation"]);
                //\Doctrine\Common\Util\Debug::dump($data["Livrable"]["remarques"]);
                
                
                //On regard s'il existe déjà des données (Livrables)
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeLivrable');
                $listProjetLivrable = $repository->findByProjet($projet); 
             
                //On regard s'il existe déjà des données (Jalons)
                $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetListeJalonDate');
                $listProjetJalonDate = $repository->findByProjet($projet); 
                
                $em = $this->getDoctrine()->getEntityManager();

                /***********/               
                // LIVRABLES
                if(sizeof($listProjetLivrable) != 0)
                {
                    // On supprime tout?
                    foreach($listProjetLivrable as $livrable)
                    {
                        $em->remove($livrable);
                        $em->flush();
                    }
                }
               
                $i = 0;
                foreach ($data["Livrable"]["id"] as $liv)
                {
                    $stepLivrable = new ProjetListeLivrable;

                    // On récupère le livrable correspondant à l'id
                    $id = $data["Livrable"]["id"][$i];
                    $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetLivrable');            
                    $livrable = $repository->findOneBy(array('id' => $id));

                    $stepLivrable->setLivrable($livrable);
                    $stepLivrable->setProjet($projet);

                    //Date Prev
                    if($data["Livrable"]["datePrev"][$i] != "")
                    {
                        $var = $data["Livrable"]["datePrev"][$i];
                        $date = str_replace('/', '-', $var);
                        $format = date('Y-m-d', strtotime($date));     
                        $datePrev = new \DateTime($format);
                        $stepLivrable->setDatePrev($datePrev);
                    }

                    //Date Rev
                    if($data["Livrable"]["dateRev"][$i] != "")
                    {
                        $var = $data["Livrable"]["dateRev"][$i];
                        $date = str_replace('/', '-', $var);
                        $format = date('Y-m-d', strtotime($date));     
                        $dateRev = new \DateTime($format);
                        $stepLivrable->setDateRev($dateRev);
                    }

                    // Si checkbox validation coché
                    if(isset($data["Livrable"]["validation"]["Ref".$id]))
                    {
                        $stepLivrable->setValidationEffective($data["Livrable"]["validation"]["Ref".$id]);
                    }

                    $stepLivrable->setRemarques($data["Livrable"]["remarques"][$i]);

                    $em->persist($stepLivrable);
                    $em->flush();

                    $i++;
                }     

                /***********/               
                // JALONS
                if(sizeof($listProjetJalonDate) != 0)
                {
                    // On supprime tout?
                    foreach($listProjetJalonDate as $jalon)
                    {
                        $em->remove($jalon);
                        $em->flush();
                    }
                }
                
                $j = 0;
                foreach ($data["Jalon"]["id"] as $jal)
                {
                    $stepJalon = new ProjetListeJalonDate();

                    // On récupère le Jalon correspondant à l'id
                    $id = $data["Jalon"]["id"][$j];
                    $repository = $this->getDoctrine()->getManager()->getRepository('NIPAProjetBundle:ProjetJalonDate');            
                    $jalon = $repository->findOneBy(array('id' => $id));

                    $stepJalon->setJalonDate($jalon);
                    $stepJalon->setProjet($projet);

                    //Date Prev
                    if($data["Jalon"]["datePrev"][$j] != "")
                    {
                        $var = $data["Jalon"]["datePrev"][$j];
                        $date = str_replace('/', '-', $var);
                        $format = date('Y-m-d', strtotime($date));     
                        $datePrev = new \DateTime($format);
                        $stepJalon->setDatePrev($datePrev);
                    }

                    //Date Rev
                    if($data["Jalon"]["dateRev"][$j] != "")
                    {
                        $var = $data["Jalon"]["dateRev"][$j];
                        $date = str_replace('/', '-', $var);
                        $format = date('Y-m-d', strtotime($date));     
                        $dateRev = new \DateTime($format);
                        $stepJalon->setDateRev($dateRev);
                    }

                    // Si checkbox validation coché
                    if(isset($data["Jalon"]["validation"]["Ref".$id]))
                    {
                        $stepJalon->setValidationEffective($data["Jalon"]["validation"]["Ref".$id]);
                    }

                    $stepJalon->setRemarques($data["Jalon"]["remarques"][$j]);

                    $em->persist($stepJalon);
                    $em->flush();

                    $j++;
                }   
                
                /***********/               
                
                $this->get('session')->getFlashBag()->add('success','Mise à jour des données');  

                return new JsonResponse(array('message' => 'Success!'), 200);

                $response = new JsonResponse(array('message' => 'Error'), 400);

                return $response;   
            
             }

        }    
    
    }
    
    
}