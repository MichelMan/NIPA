<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetListeJalonDate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetListeJalonDateRepository")
 */
class ProjetListeJalonDate
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
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\ProjetJalonDate")
     * @ORM\JoinColumn(name="projet_JalonDate_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $jalonDate;
    
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
     * @return ProjetListeJalonDate
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
     * @return ProjetListeJalonDate
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
     * @return ProjetListeJalonDate
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
     * @return ProjetListeJalonDate
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
     * Set jalonDate
     *
     * @param ProjetJalonDate $jalonDate
     *
     * @return ProjetListeJalonDate
     */
    public function setJalonDate(ProjetJalonDate $jalonDate)
    {
        $this->jalonDate = $jalonDate;

        return $this;
    }

    /**
     * Get jalonDate
     *
     * @return ProjetJalonDate
     */
    public function getJalonDate()
    {
        return $this->jalonDate;
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

