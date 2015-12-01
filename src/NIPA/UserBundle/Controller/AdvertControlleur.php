<?php
// src/OC/PlatformBundle/Controller/AdvertController.php
/*
namespace NIPA\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdvertController extends Controller
{
  public function addAction(Request $request)
  {
    // On vérifie que l'utilisateur dispose bien du rôle ROLE_AUTEUR
    if (!$this->get('security.context')->isGranted('ROLE_AUTEUR')) {
      // Sinon on déclenche une exception « Accès interdit »
      throw new AccessDeniedException('Accès limité aux auteurs.');
    }

    // Ici l'utilisateur a les droits suffisant,
    // on peut ajouter une annonce
  }
}
 * */

echo "TOTO";