<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetByPassPhase
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetByPassPhaseRepository")
 */
class ProjetByPassPhase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\Projet")
     */
    private $projet;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\ProjetPhase")
     */
    private $refPhase;

    /**
     * @var string
     *
     * @ORM\Column(name="ByPass", type="string", length=10)
     */
    private $byPass;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set projet
     *
     * @param Projet $projet
     *
     * @return ProjetValidationPhase
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }   
    

   
    /**
     * Set refPhase
     *
     * @param ProjetPhase $refPhase
     *
     * @return ProjetValidationPhase
     */
    public function setRefPhase(ProjetPhase $refPhase)
    {
        $this->refPhase = $refPhase;

        return $this;
    }

    /**
     * Get refPhase
     *
     * @return ProjetPhase
     */
    public function getRefPhase()
    {
        return $this->refPhase;
    }

    /**
     * Set byPass
     *
     * @param string $byPass
     *
     * @return ProjetByPassPhase
     */
    public function setByPass($byPass)
    {
        $this->byPass = $byPass;

        return $this;
    }

    /**
     * Get byPass
     *
     * @return string
     */
    public function getByPass()
    {
        return $this->byPass;
    }
}

