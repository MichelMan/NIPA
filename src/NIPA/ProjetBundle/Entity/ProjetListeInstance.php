<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetListeInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetListeInstanceRepository")
 */
class ProjetListeInstance
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
     * @var \DateTime
     *
     * @ORM\Column(name="DatePrev", type="date", nullable=true)
     */
    private $datePrev;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRev", type="date", nullable=true)
     */
    private $dateRev;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ValidationEffective", type="boolean", nullable=true)
     */
    private $validationEffective;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarques", type="string", length=2500, nullable=true)
     */
    private $remarques;

    /**
     * @var string
     *
     * @ORM\Column(name="statutInstance", type="string", length=25, nullable=true)
     */
    private $statutInstance;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeInstance")
     * @ORM\JoinColumn(name="projet_instance_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $instance;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\Projet")
     */
    private $projet;
    
    
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
     * Set datePrev
     *
     * @param \DateTime $datePrev
     *
     * @return ProjetListeInstance
     */
    public function setDatePrev($datePrev)
    {
        $this->datePrev = $datePrev;

        return $this;
    }

    /**
     * Get datePrev
     *
     * @return \DateTime
     */
    public function getDatePrev()
    {
        return $this->datePrev;
    }

    /**
     * Set dateRev
     *
     * @param \DateTime $dateRev
     *
     * @return ProjetListeInstance
     */
    public function setDateRev($dateRev)
    {
        $this->dateRev = $dateRev;

        return $this;
    }

    /**
     * Get dateRev
     *
     * @return \DateTime
     */
    public function getDateRev()
    {
        return $this->dateRev;
    }

    /**
     * Set validationEffective
     *
     * @param boolean $validationEffective
     *
     * @return ProjetListeInstance
     */
    public function setValidationEffective($validationEffective)
    {
        $this->validationEffective = $validationEffective;

        return $this;
    }

    /**
     * Get validationEffective
     *
     * @return boolean
     */
    public function getValidationEffective()
    {
        return $this->validationEffective;
    }

    /**
     * Set remarques
     *
     * @param string $remarques
     *
     * @return ProjetListeInstance
     */
    public function setRemarques($remarques)
    {
        $this->remarques = $remarques;

        return $this;
    }

    /**
     * Get remarques
     *
     * @return string
     */
    public function getRemarques()
    {
        return $this->remarques;
    }

    /**
     * Set statutInstance
     *
     * @param string $statutInstance
     *
     * @return ProjetListeInstance
     */
    public function setStatutInstance($statutInstance)
    {
        $this->statutInstance = $statutInstance;

        return $this;
    }

    /**
     * Get statutInstance
     *
     * @return string
     */
    public function getStatutInstance()
    {
        return $this->statutInstance;
    }

    /**
     * Set instance
     *
     * @param DemandeInstance $instance
     *
     * @return ProjetListeInstance
     */
    public function setInstance(DemandeInstance $instance)
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * Get instance
     *
     * @return DemandeInstance
     */
    public function getInstance()
    {
        return $this->instance;
    }
    
    
    /**
     * Set projet
     *
     * @param Demande $projet
     *
     * @return ProjetListeInstance
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
    
}

