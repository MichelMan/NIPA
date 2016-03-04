<?php

namespace NIPA\ProjetBundle\Manager;

use Doctrine\ORM\EntityManager;
use NIPA\ProjetBundle\Manager\BaseManager;
use NIPA\ProjetBundle\Entity\Projet;

class ProjetManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadProjet($reference) {
        return $this->getRepository()
                ->findOneBy(array('referenceProjet' => $reference));
    }
    
    public function loadAllProjet() {
        return $this->getRepository()
                ->findAll();
    }    
  
    /**
    * Save Projet entity
    *
    * @param Projet $projet
    */
    public function saveProjet(Projet $projet)
    {
        $this->persistAndFlush($projet);
    }

    /**
    * Delete Projet entity
    *
    * @param Projet $projet
    */
    public function deleteProjet(Projet $projet)
    {
        $this->deleteAndFlush($projet);
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('NIPAProjetBundle:Projet');
    }

}