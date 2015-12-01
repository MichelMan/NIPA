<?php

namespace NIPA\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use NIPA\UserBundle\Manager\BaseManager;
use NIPA\UserBundle\Entity\Utilisateur;

class UserManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadUser($userId) {
        return $this->getRepository()
                ->findOneBy(array('id' => $userId));
    }

    /**
    * Save Utilisateur entity
    *
    * @param Utilisateur $user
    */
    public function saveUser(Utilisateur $user)
    {
        $this->persistAndFlush($user);
    }
    
    public function getPreviousUser($userId) {
        return $this->getRepository()
                ->getAdjacentUser($userId, false)
                ->getQuery()
                ->setMaxResults(1)
                ->getOneOrNullResult();
    }

    public function getNextUser($userId) {
        return $this->getRepository()
                ->getAdjacentUser($userId, true)
                ->getQuery()
                ->setMaxResults(1)
                ->getOneOrNullResult();
    }

    public function isAuthorized(Utilisateur $user, $memberId)
    {
        return ($user->getMember()->getId() == $memberId) ?
                true:
                false;
    }

    public function getPreviousAndNextUser($user)
    {
        return array(
            'prev' => $this->getPreviousUser($user->getId()),
            'user' => $user,
            'next' => $this->getNextUser($user->getId()),
            'voted' => false
        );
    }

    public function getRepository()
    {
        return $this->em->getRepository('NIPAUserBundle:Utilisateur');
    }

}
