<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetLivrable
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetLivrableRepository")
 */
class ProjetLivrable
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
     * @ORM\Column(name="Description", type="string", length=2500, nullable= true)
     */
    private $description;
       
    /**
     * @var string
     *
     * @ORM\Column(name="Developpement", type="string", length=25, nullable= true)
     */
    private $developpement;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Reference", type="string", length=50)
     */
    private $reference;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\ProjetPhase")
     */
    private $refPhase;    


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
     * @return ProjetLivrable
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
     * Set description
     *
     * @param string $description
     *
     * @return ProjetLivrable
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }       
        
    /**
     * Set developpement
     *
     * @param string $developpement
     *
     * @return ProjetLivrable
     */
    public function setDeveloppement($developpement)
    {
        $this->developpement = $developpement;

        return $this;
    }

    /**
     * Get developpement
     *
     * @return string
     */
    public function getDeveloppement()
    {
        return $this->developpement;
    }     
    
    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return ProjetLivrable
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
     * Set refPhase
     *
     * @param ProjetPhase $refPhase
     *
     * @return ProjetLivrable
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
    
}

