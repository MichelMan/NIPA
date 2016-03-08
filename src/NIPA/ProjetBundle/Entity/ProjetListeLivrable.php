<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetListeLivrable
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetListeLivrableRepository")
 */
class ProjetListeLivrable
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
     * @return ProjetListeLivrable
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
     * @return ProjetListeLivrable
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
     * @return ProjetListeLivrable
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
     * @return ProjetListeLivrable
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
     * Set livrable
     *
     * @param ProjetLivrable $livrable
     *
     * @return ProjetListeLivrable
     */
    public function setLivrable(ProjetLivrable $livrable)
    {
        $this->livrable = $livrable;

        return $this;
    }

    /**
     * Get livrable
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
     * @return ProjetListeLivrable
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

