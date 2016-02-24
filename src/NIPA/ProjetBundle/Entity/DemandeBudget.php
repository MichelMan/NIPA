<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeBudget
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\DemandeBudgetRepository")
 */
class DemandeBudget
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
     * @ORM\Column(name="IPP", type="string", length=25)
     */
    private $iPP;

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
     * @ORM\Column(name="Commentaires", type="string", length=2500, nullable= true)
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\Demande")
     */
    private $demande;


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
     * Set iPP
     *
     * @param string $iPP
     *
     * @return DemandeBudget
     */
    public function setIPP($iPP)
    {
        $this->iPP = $iPP;

        return $this;
    }

    /**
     * Get iPP
     *
     * @return string
     */
    public function getIPP()
    {
        return $this->iPP;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DemandeBudget
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
     * @return DemandeBudget
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
     * @return DemandeBudget
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

    /**
     * Set demande
     *
     * @param Demande $demande
     *
     * @return DemandeBudget
     */
    public function setDemande(Demande $demande)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return Demande
     */
    public function getDemande()
    {
        return $this->demande;
    }
}

