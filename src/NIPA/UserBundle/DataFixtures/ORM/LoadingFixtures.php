<?php
# Fichier videotheque/src/Iabsis/Bundle/VideothequeBundle/DataFixtures/ORM/LoadingFixtures.php
/* Les Fixtures doivent �tres stock�es dans le namespace suivant */
namespace  NIPA\UserBundle\DataFixtures\ORM;

/*
 *  On a besoin de recourir � l'interface FixtureInterface pour d�finir une fixture alors on le d�clare
 * Si nous n'avions pas mis ce use, on aurait d� taper
 * class LoadingFixtures implements Doctrine\Common\DataFixtures\FixtureInterface pour l'impl�mentation
 * de l'interface FixtureInterface, ce qui avouons-le n'est pas toujours tr�s pratique, surtout si on
 * veut utiliser plusieurs fois l'objet / interface en question.
 */
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/*
 * Nous aurons besoin de nos entit�s Genre et Film �galement, on le d�clare donc ici aussi...
 */
use NIPA\UserBundle\Entity\Utilisateur;

/*
 * Les fixtures sont des objets qui doivent obligatoireemnt impl�menter l'interface FixtureInterface
 */
class LoadingFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
  {
   

      // On cr�e l'utilisateur
      $user = new Utilisateur;

      // Le nom d'utilisateur et le mot de passe sont identiques
      $user->setIdentifiant("u123456");
	  $user->setPrenom("xxx");
	  $user->setNom("xxx");
	  $user->setEmail("xxx");
	  $user->setPrenom(true);
	  $user->setPassword("xxx");
	  $user->setSalt("");
	  $user->setRoles(array('ROLE_USER'));

      // On le persiste
      $manager->persist($user);
    

    // On d�clenche l'enregistrement
    $manager->flush();
  }
}
?>