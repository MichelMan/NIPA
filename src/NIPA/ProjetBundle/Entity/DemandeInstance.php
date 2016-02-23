<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\DemandeInstanceRepository")
 */
class DemandeInstance
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
     * @ORM\Column(name="Reference", type="string", length=25)
     */
    private $reference;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=25)
     */
    private $nom;


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
     * Set Reference
     *
     * @param string $reference
     *
     * @return DemandeStatut
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get Reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }    
    
    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return DemandeInstance
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
}
