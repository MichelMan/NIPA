<?php
# Fichier videotheque/src/Iabsis/Bundle/VideothequeBundle/DataFixtures/ORM/LoadingFixtures.php
/* Les Fixtures doivent êtres stockées dans le namespace suivant */
namespace  NIPA\UserBundle\DataFixtures\ORM;

/*
 *  On a besoin de recourir à l'interface FixtureInterface pour définir une fixture alors on le déclare
 * Si nous n'avions pas mis ce use, on aurait dû taper
 * class LoadingFixtures implements Doctrine\Common\DataFixtures\FixtureInterface pour l'implémentation
 * de l'interface FixtureInterface, ce qui avouons-le n'est pas toujours très pratique, surtout si on
 * veut utiliser plusieurs fois l'objet / interface en question.
 */
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/*
 * Nous aurons besoin de nos entités Genre et Film également, on le déclare donc ici aussi...
 */
use NIPA\UserBundle\Entity\Utilisateur;

/*
 * Les fixtures sont des objets qui doivent obligatoireemnt implémenter l'interface FixtureInterface
 */
class LoadingFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
  {
   

      // On crée l'utilisateur
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
    

    // On déclenche l'enregistrement
    $manager->flush();
  }
}
?>