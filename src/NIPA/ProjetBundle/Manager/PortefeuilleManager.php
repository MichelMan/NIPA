<?php

namespace NIPA\ProjetBundle\Manager;

use Doctrine\ORM\EntityManager;
use NIPA\ProjetBundle\Manager\BaseManager;
use NIPA\ProjetBundle\Entity\Portefeuille;

class PortefeuilleManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadPortefeuille($reference) {
        return $this->getRepository()
                ->findOneBy(array('referencePortefeuille' => $reference));
    }
    
    public function loadAllPortefeuille() {
        return $this->getRepository()
                ->findAll();
    }    
  
    /**
    * Save Portefeuille entity
    *
    * @param Portefeuille $portefeuille 
    */
    public function savePortefeuille(Portefeuille $portefeuille)
    {
        $this->persistAndFlush($portefeuille);
    }

    /**
    * Delete Portefeuille entity
    *
    * @param Portefeuille $portefeuille 
    */
    public function deletePortefeuille(Portefeuille $portefeuille)
    {
        $this->deleteAndFlush($portefeuille);
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('NIPAProjetBundle:Portefeuille');
    }

}