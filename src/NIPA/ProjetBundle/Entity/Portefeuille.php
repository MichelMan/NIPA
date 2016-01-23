<?php

namespace NIPA\ProjetBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert; //Pour ajouter des contraintes / règles sur notre entité Utilisateur
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * portefeuille
 *
 * @ORM\Table(name="portefeuille")
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\PortefeuilleRepository")
 */
class Portefeuille
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
     * @ORM\Column(name="IPP", type="string", length=25)
     */
    
    private $IPP;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */    
    
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\PortefeuilleEnveloppe")
     * @ORM\JoinColumn(name="portefeuille_enveloppe_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $portefeuilleEnveloppe;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\PortefeuilleAnnee")
     * @ORM\JoinColumn(name="portefeuille_annee_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $portefeuilleAnnee;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Cloture", type="date", nullable=true)
     */
    private $dateCloture=null;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\PortefeuilleStatut")
     * @ORM\JoinColumn(name="portefeuille_statut_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $portefeuilleStatut;
    
    /**
     * @ORM\ManyToMany(targetEntity="NIPA\ProjetBundle\Entity\Demande", inversedBy="portefeuilles")
     * @ORM\JoinTable(name="portefeuilles_demandes")
     */
    private $demande;
    
    
   public function __construct()
   {
       $this->demande = new ArrayCollection(); // Collection 
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
     * Set IPP
     *
     * @param string $IPP
     *
     * @return portfeuille
     */
    public function setIPP($IPP)
    {
        $this->IPP = $IPP;

        return $this;
    }

    /**
     * Get IPP
     *
     * @return string
     */
    public function getIPP()
    {
        return $this->IPP;
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
     * @return portefeuille
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
     * @return portefeuille
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
     * @param PortefeuilleStatut $portefeuilleStatut
     *
     * @return portefeuille
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
    
    /**
     * Add demande
     *
     * @param \NIPA\ProjetBundle\Entity\Demande $demande
     */
    public function addDemande(\NIPA\ProjetBundle\Entity\Demande $demande)
    {
        $this->demande[] = $demande;
        //$groupe->addUtilisateur($this);
        //$this->groupe[] = $groupe;
    }
    
    /**
     * Add demande
     *
     * @param \NIPA\ProjetBundle\Entity\Demande $demande
     */
    public function addDemandes(\NIPA\ProjetBundle\Entity\Demande $demande)
    {
        //$this->groupe[] = $groupe;
        $demande->addPortefeuille($this);
        $this->demande[] = $demande;
    }

    /**
     * Remove demande
     *
     * @param \NIPA\ProjetBundle\Entity\Demande $demande
     */
    public function removeDemandes(\NIPA\ProjetBundle\Entity\Demande $demande)
    {
        //$this->groupe[] = $groupe;
        //$groupe->addUtilisateur($this);
        //$this->groupe[] = $groupe;
        $this->getDemande()->removeElement($demande);
    }
    
    /**
     * Set demande
     *
     * @param \Doctrine\Common\Collections\Collection $demande
     */
    public function setDemande(\Doctrine\Common\Collections\Collection $demande)
    {
        $this->demande = $demande;
    }
  
    /**
     * Get demande
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDemande()
    {
        return $this->demande;
    }
    
    public function getDemandesToArray()
    {
        return $this->demande->toArray();                
    }
        
    
}

