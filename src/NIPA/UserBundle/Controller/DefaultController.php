<?php

namespace NIPA\UserBundle\Controller;

use NIPA\UserBundle\Entity\Utilisateur;
use NIPA\UserBundle\Entity\Groupe;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="accueil")
     * @Template()
     */
    public function indexAction()
    {
        //return array();
        return $this->render('NIPAUserBundle:Default:accueil.html.twig', array());
    }
    
    /**
     * @Route("/test/", name="test")
     * @Template()
     */
   /*public function testAction()
   {
       $user = new Utilisateur();
       $user->setIdentifiant("u136227");
       $user->setPrenom("Michel");
       $user->setNom("Man");
       $user->setEmail("michel.man@sfr.com");
       $user->setAdmin(true);
       $user->setPassword("Aziat987");

       echo "Création de l'utilisateur: ".$user->getPrenom()." ".$user->getNom()."<br>";

       $em = $this->getDoctrine()->getEntityManager();
       $em->persist($user);
       $em->flush();
       
       echo "Le user a bien été enregistré: ".$user->getId();

       exit;
   }
    */
    
   /*public function testAction()
   {
       $em = $this->getDoctrine()->getEntityManager();
       $id_U = 4; // ID du user
       
       $user = $this->getDoctrine()->getRepository('NIPAUserBundle:Utilisateur')->find($id_U);
       echo "Le user récupéré porte l'ID: ".$user->getId()." et il s'agit de: ".$user->getPrenom()." ".$user->getNom()."<br>";
       
       $groupe = $this->getDoctrine()->getRepository('NIPAUserBundle:Groupe')->find(3);
       echo $groupe->getNom();
       $user->addGroupe($groupe);
       
       //$em->persist($groupe); // On persiste
       
       echo "<br>";
       
       $groupe2 = $this->getDoctrine()->getRepository('NIPAUserBundle:Groupe')->find(4);
       echo $groupe2->getNom();
       $user->addGroupe($groupe2);
      
       //$em->persist($groupe2); // On persiste

       $em->flush(); // On sauvegarde en BDD 

       exit;
   }*/
   
   /*public function testAction()
   {
    // Liste des noms de catégorie à ajouter
    $names = array(
      'Manager Application',
      'Manager Marketing',
      'Manager MOA',
      'MOA',
      'MOE',
      'SDM',
      'Métiers',
      'Visiteur'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $groupe = new Groupe();
      $groupe->setNom($name);

      // On la persiste
       $em = $this->getDoctrine()->getEntityManager();
       $em->persist($groupe);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $em->flush();
    
    echo "Les groupes ont bien été enregistré";
    
    exit;
   }*/
    public function testAction()
    {
        $id = 4; // ID 

        $user = $this->getDoctrine()->getRepository('NIPAUserBundle:Utilisateur')->find($id);

        return array('user' => $user);
    }

}

