<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeListeInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\DemandeListeInstanceRepository")
 */
class DemandeListeInstance
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
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeInstance")
     * @ORM\JoinColumn(name="demande_instance_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $instance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DatePrev", type="date", nullable = true)
     */
    private $datePrev;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRev", type="date", nullable = true)
     */
    private $dateRev;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ValidationEffective", type="boolean", nullable = true)
     */
    private $validationEffective;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeStatutInstance")
     * @ORM\JoinColumn(name="demande_statut_instance_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $statutInstance;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarques", type="string", length=2500, nullable = true)
     */
    private $remarques;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\Demande")
     */
    private $demande;
    
    
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
     * Set instance
     *
     * @param DemandeInstance $instance
     *
     * @return DemandeListeInstance
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
     * Set datePrev
     *
     * @param \DateTime $datePrev
     *
     * @return DemandeListeInstance
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
     * @return DemandeListeInstance
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
     * @return DemandeListeInstance
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
     * Set statutInstance
     *
     * @param DemandeStatutInstance $statutInstance
     *
     * @return DemandeListeInstance
     */
    public function setStatut(DemandeStatutInstance $statutInstance)
    {
        $this->statutInstance = $statutInstance;

        return $this;
    }

    /**
     * Get statutInstance
     *
     * @return DemandeStatutInstance
     */
    public function getStatut()
    {
        return $this->statutInstance;
    }

    /**
     * Set remarques
     *
     * @param string $remarques
     *
     * @return DemandeListeInstance
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
     * Set demande
     *
     * @param Demande $demande
     *
     * @return DemandeBudget
     */
    public function setDemande(Demande $demande)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return Demande
     */
    public function getDemande()
    {
        return $this->demande;
    }    
    
}

