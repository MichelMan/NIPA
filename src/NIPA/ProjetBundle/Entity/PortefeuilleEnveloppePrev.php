<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortefeuilleEnveloppePrev
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\PortefeuilleEnveloppePrevRepository")
 */
class PortefeuilleEnveloppePrev
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
     * @ORM\Column(name="Nom", type="string", length=25)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="Montant", type="float")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaires", type="string", length=2500, nullable=true)
     */
    private $commentaires;


    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\Portefeuille")
     */
    private $portefeuille;
    
   public function __construct()
   {

   }    

/**
     * Get portefeuille
     *
     * @return Portefeuille
     */
    public function getPortefeuille()
    {
        return $this->portefeuille;
    }

    /**
     * Set portefeuille
     *
     * @param Portefeuille $portefeuille
     *
     * @return PortefeuilleEnveloppeCons
     */
    public function setPortefeuille($portefeuille)
    {
        $this->portefeuille = $portefeuille;

        return $this;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return PortefeuilleEnveloppePrev
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PortefeuilleEnveloppePrev
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return PortefeuilleEnveloppePrev
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return PortefeuilleEnveloppePrev
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}

