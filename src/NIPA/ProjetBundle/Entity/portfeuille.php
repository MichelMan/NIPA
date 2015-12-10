<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; //Pour ajouter des contraintes / règles sur notre entité Utilisateur
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * portfeuille
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Entity\portfeuilleRepository")
 */
class portfeuille
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
     * @Assert\NotBlank(message="Reference must not be empty")
     * @Assert\Length(max=7)    
     * @ORM\Column(name="Reference_Portefeuille", type="string", length=25, unique=true)
     */
    private $referencePortefeuille;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\PortefeuilleEnveloppe")
     */
    private $portefeuilleEnveloppe;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\PortefeuilleAnnee")
     */
    private $portefeuilleAnnee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Cloture", type="date")
     */
    private $dateCloture;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\PortefeuilleStatut")
     */
    private $portefeuilleStatut;

    
   public function __construct()
   {

   }

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
     * Set referencePortefeuille
     *
     * @param string $referencePortefeuille
     *
     * @return portfeuille
     */
    public function setReferencePortefeuille($referencePortefeuille)
    {
        $this->referencePortefeuille = $referencePortefeuille;

        return $this;
    }

    /**
     * Get referencePortefeuille
     *
     * @return string
     */
    public function getReferencePortefeuille()
    {
        return $this->referencePortefeuille;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return portfeuille
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
     * @return portfeuille
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
     * Set PortefeuilleAnnee
     *
     * @param PortefeuilleAnnee $portefeuilleAnnee
     *
     * @return portfeuille
     */
    public function setPortefeuilleAnnee(PortefeuilleAnnee $portefeuilleAnnee)
    {
        $this->portefeuilleAnnee = $portefeuilleAnnee;

        return $this;
    }

    /**
     * Get PortefeuilleAnnee
     *
     * @return PortefeuilleAnnee
     */
    public function getPortefeuilleAnnee()
    {
        return $this->portefeuilleAnnee;
    }    
    
    /**
     * Set portefeuilleEnveloppe
     *
     * @param PortefeuilleEnveloppe $portefeuilleEnveloppe
     *
     * @return portfeuille
     */
    public function setPortefeuilleEnveloppe(PortefeuilleEnveloppe $portefeuilleEnveloppe)
    {
        $this->portefeuilleEnveloppe = $portefeuilleEnveloppe;

        return $this;
    }

    /**
     * Get PortefeuilleEnveloppe
     *
     * @return PortefeuilleEnveloppe
     */
    public function getPortefeuilleEnveloppe()
    {
        return $this->portefeuilleEnveloppe;
    }

    /**
     * Set dateCloture
     *
     * @param \DateTime $dateCloture
     *
     * @return portfeuille
     */
    public function setDateCloture($dateCloture)
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    /**
     * Get dateCloture
     *
     * @return \DateTime
     */
    public function getDateCloture()
    {
        return $this->dateCloture;
    }

    /**
     * Set PortefeuilleStatut
     *
     * @param string $portefeuilleStatut
     *
     * @return portfeuille
     */
    public function setPortefeuilleStatut(PortefeuilleStatut $portefeuilleStatut)
    {
        $this->portefeuilleStatut = $portefeuilleStatut;

        return $this;
    }

    /**
     * Get PortefeuilleStatut
     *
     * @return PortefeuilleStatut
     */
    public function getPortefeuilleStatut()
    {
        return $this->portefeuilleStatut;
    }
}

