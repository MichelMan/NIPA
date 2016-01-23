<?php

namespace NIPA\ProjetBundle\Manager;

use Doctrine\ORM\EntityManager;
use NIPA\ProjetBundle\Manager\BaseManager;
use NIPA\ProjetBundle\Entity\Demande;

class DemandeManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadDemande($reference) {
        return $this->getRepository()
                ->findOneBy(array('referenceDemande' => $reference));
    }
    
    public function loadAllDemande() {
        return $this->getRepository()
                ->findAll();
    }    
  
    /**
    * Save Demande entity
    *
    * @param Demande $demande
    */
    public function saveDemande(Demande $demande)
    {
        $this->persistAndFlush($demande);
    }

    /**
    * Delete Demande entity
    *
    * @param Demande $demande 
    */
    public function deleteDemande(Demande $demande)
    {
        $this->deleteAndFlush($demande);
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('NIPAProjetBundle:Demande');
    }

}