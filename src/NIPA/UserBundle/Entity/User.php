<?php
// src/NIPA/UserBundle/Entity/User.php

namespace NIPA\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="tuto_user")
*/
//class User extends BaseUser
class User
{
   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;

   public function __construct()
   {
       parent::__construct();
       // your own logic
   }
}