<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetPhase
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetPhaseRepository")
 */
class ProjetPhase
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
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Reference", type="string", length=50)
     */
    private $reference;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\ProjetEtape")
     */
    private $refEtape;    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="Hidden", type="boolean")
     */
    private $hidden;    
    
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
     * Set nom
     *
     * @param string $nom
     *
     * @return ProjetPhase
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return ProjetPhase
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    
    /**
     * Set refEtape
     *
     * @param ProjetEtape $refEtape
     *
     * @return ProjetPhase
     */
    public function setRefEtape(ProjetEtape $refEtape)
    {
        $this->refEtape = $refEtape;

        return $this;
    }

    /**
     * Get refEtape
     *
     * @return ProjetStatut
     */
    public function getRefEtape()
    {
        return $this->refEtape;
    }    
    
    /**
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return ProjetPhase
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }    
    
}

