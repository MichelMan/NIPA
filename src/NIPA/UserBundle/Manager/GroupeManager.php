<?php

namespace NIPA\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use NIPA\UserBundle\Manager\BaseManager;
use NIPA\UserBundle\Entity\Groupe;

class GroupeManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadGroupe($groupeId) {
        return $this->getRepository()
                ->findOneBy(array('id' => $groupeId));
    }
    
    public function loadAllGroupe() {
        return $this->getRepository()
                ->findAll();
    }    
    
    /**
    * Save Groupe entity
    *
    * @param Groupe $groupe 
    */
    public function saveGroupe(Groupe $groupe)
    {
        $this->persistAndFlush($groupe);
    }

    /**
    * Delete Groupe entity
    *
    * @param Groupe $groupe 
    */
    public function deleteGroupe(Groupe $groupe)
    {
        $this->deleteAndFlush($groupe);
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('NIPAUserBundle:Groupe');
    }

}