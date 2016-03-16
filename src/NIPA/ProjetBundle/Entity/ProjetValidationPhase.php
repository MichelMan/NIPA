<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetValidationPhase
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetValidationPhaseRepository")
 */
class ProjetValidationPhase
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
     * @ORM\Column(name="validationJalon", type="string", length=25, nullable = true)
     */
    private $validationJalon;

    /**
     * @var string
     *
     * @ORM\Column(name="validationInstance", type="string", length=25, nullable = true)
     */
    private $validationInstance;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\Projet")
     */
    private $projet;

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
     * @return ProjetValidationPhase
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
     * Set validationJalon
     *
     * @param string $validationJalon
     *
     * @return ProjetValidationPhase
     */
    public function setValidationJalon($validationJalon)
    {
        $this->validationJalon = $validationJalon;

        return $this;
    }

    /**
     * Get validationJalon
     *
     * @return string
     */
    public function getValidationJalon()
    {
        return $this->validationJalon;
    }

    /**
     * Set validationInstance
     *
     * @param string $validationInstance
     *
     * @return ProjetValidationPhase
     */
    public function setValidationInstance($validationInstance)
    {
        $this->validationInstance = $validationInstance;

        return $this;
    }

    /**
     * Get validationInstance
     *
     * @return string
     */
    public function getValidationInstance()
    {
        return $this->validationInstance;
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
    
}

