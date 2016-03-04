<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetListeSteps
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetListeStepsRepository")
 */
class ProjetListeSteps
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
     * @ORM\Column(name="DatePrev", type="date")
     */
    private $datePrev;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRev", type="date")
     */
    private $dateRev;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ValidationEffective", type="boolean")
     */
    private $validationEffective;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarques", type="string", length=2500)
     */
    private $remarques;

    /**
     * @var string
     *
     * @ORM\Column(name="statutInstance", type="string", length=25)
     */
    private $statutInstance;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=25)
     */
    private $type;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeInstance")
     * @ORM\JoinColumn(name="projet_instance_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $instance;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\ProjetLivrable")
     * @ORM\JoinColumn(name="projet_livrable_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $livrable;
    
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
     * @return ProjetListeSteps
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
     * @return ProjetListeSteps
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
     * @return ProjetListeSteps
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
     * @return ProjetListeSteps
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
     * @return ProjetListeSteps
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
     * Set type
     *
     * @param string $type
     *
     * @return ProjetListeSteps
     */
    public function setype($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    
    /**
     * Set instance
     *
     * @param DemandeInstance $instance
     *
     * @return ProjetListeSteps
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
     * Set livrable
     *
     * @param ProjetLivrable $livrable
     *
     * @return ProjetListeSteps
     */
    public function setLivrable(ProjetLivrable $livrable)
    {
        $this->livrable = $livrable;

        return $this;
    }

    /**
     * Get instance
     *
     * @return ProjetLivrable
     */
    public function getLivrable()
    {
        return $this->livrable;
    }
    
    
    /**
     * Set projet
     *
     * @param Demande $projet
     *
     * @return ProjetListeSteps
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

