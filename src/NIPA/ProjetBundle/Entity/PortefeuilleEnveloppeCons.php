<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortefeuilleEnveloppeCons
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\PortefeuilleEnveloppeConsRepository")
 */
class PortefeuilleEnveloppeCons
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
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="Montant_Mensuel", type="float")
     */
    private $montantMensuel;

    /**
     * @var float
     *
     * @ORM\Column(name="Montant_Cumul", type="float")
     */
    private $montantCumul;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaires", type="string", length=2500)
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PortefeuilleEnveloppeCons
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
     * Set montantMensuel
     *
     * @param float $montantMensuel
     *
     * @return PortefeuilleEnveloppeCons
     */
    public function setMontantMensuel($montantMensuel)
    {
        $this->montantMensuel = $montantMensuel;

        return $this;
    }

    /**
     * Get montantMensuel
     *
     * @return float
     */
    public function getMontantMensuel()
    {
        return $this->montantMensuel;
    }

    /**
     * Set montantCumul
     *
     * @param float $montantCumul
     *
     * @return PortefeuilleEnveloppeCons
     */
    public function setMontantCumul($montantCumul)
    {
        $this->montantCumul = $montantCumul;

        return $this;
    }

    /**
     * Get montantCumul
     *
     * @return float
     */
    public function getMontantCumul()
    {
        return $this->montantCumul;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return PortefeuilleEnveloppeCons
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

