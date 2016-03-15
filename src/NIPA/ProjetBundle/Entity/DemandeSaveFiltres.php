<?php

namespace NIPA\ProjetBundle\Entity;

use NIPA\UserBundle\Entity\Utilisateur;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeSaveFiltres
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\DemandeSaveFiltresRepository")
 */
class DemandeSaveFiltres
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
     * @ORM\Column(name="reference", type="string", length=50, nullable = true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50, nullable = true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=50, nullable = true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="direction", type="string", length=50, nullable = true)
     */
    private $direction;

    /**
     * @var string
     *
     * @ORM\Column(name="offres", type="string", length=50, nullable = true)
     */
    private $offres;

    /**
     * @var string
     *
     * @ORM\Column(name="divers", type="string", length=50, nullable = true)
     */
    private $divers;

    /**
     * @var string
     *
     * @ORM\Column(name="interlocuteurMOA", type="string", length=50, nullable = true)
     */
    private $interlocuteurMOA;

    /**
     * @var string
     *
     * @ORM\Column(name="priorite", type="string", length=50, nullable = true)
     */
    private $priorite;

    /**
     * @var string
     *
     * @ORM\Column(name="typeEnveloppe", type="string", length=50, nullable = true)
     */
    private $typeEnveloppe;

    /**
     * @var string
     *
     * @ORM\Column(name="portefeuille", type="string", length=50, nullable = true)
     */
    private $portefeuille;

    /**
     * @var string
     *
     * @ORM\Column(name="entiteMetier", type="string", length=50, nullable = true)
     */
    private $entiteMetier;

    /**
     * @var string
     *
     * @ORM\Column(name="typeProjet", type="string", length=50, nullable = true)
     */
    private $typeProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="porteurMetier", type="string", length=50, nullable = true)
     */
    private $porteurMetier;

    /**
     * @var string
     *
     * @ORM\Column(name="SDM", type="string", length=50, nullable = true)
     */
    private $SDM;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\UserBundle\Entity\Utilisateur")
     */
    private $utilisateur;
    
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
     * Set reference
     *
     * @param string $reference
     *
     * @return DemandeSaveFiltres
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
     * Set titre
     *
     * @param string $titre
     *
     * @return DemandeSaveFiltres
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return DemandeSaveFiltres
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set direction
     *
     * @param string $direction
     *
     * @return DemandeSaveFiltres
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set offres
     *
     * @param string $offres
     *
     * @return DemandeSaveFiltres
     */
    public function setOffres($offres)
    {
        $this->offres = $offres;

        return $this;
    }

    /**
     * Get offres
     *
     * @return string
     */
    public function getOffres()
    {
        return $this->offres;
    }

    /**
     * Set divers
     *
     * @param string $divers
     *
     * @return DemandeSaveFiltres
     */
    public function setDivers($divers)
    {
        $this->divers = $divers;

        return $this;
    }

    /**
     * Get divers
     *
     * @return string
     */
    public function getDivers()
    {
        return $this->divers;
    }

    /**
     * Set interlocuteurMOA
     *
     * @param string $interlocuteurMOA
     *
     * @return DemandeSaveFiltres
     */
    public function setInterlocuteurMOA($interlocuteurMOA)
    {
        $this->interlocuteurMOA = $interlocuteurMOA;

        return $this;
    }

    /**
     * Get interlocuteurMOA
     *
     * @return string
     */
    public function getInterlocuteurMOA()
    {
        return $this->interlocuteurMOA;
    }

    /**
     * Set priorite
     *
     * @param string $priorite
     *
     * @return DemandeSaveFiltres
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;

        return $this;
    }

    /**
     * Get priorite
     *
     * @return string
     */
    public function getPriorite()
    {
        return $this->priorite;
    }

    /**
     * Set typeEnveloppe
     *
     * @param string $typeEnveloppe
     *
     * @return DemandeSaveFiltres
     */
    public function setTypeEnveloppe($typeEnveloppe)
    {
        $this->typeEnveloppe = $typeEnveloppe;

        return $this;
    }

    /**
     * Get typeEnveloppe
     *
     * @return string
     */
    public function getTypeEnveloppe()
    {
        return $this->typeEnveloppe;
    }

    /**
     * Set portefeuille
     *
     * @param string $portefeuille
     *
     * @return DemandeSaveFiltres
     */
    public function setPortefeuille($portefeuille)
    {
        $this->portefeuille = $portefeuille;

        return $this;
    }

    /**
     * Get portefeuille
     *
     * @return string
     */
    public function getPortefeuille()
    {
        return $this->portefeuille;
    }

    /**
     * Set entiteMetier
     *
     * @param string $entiteMetier
     *
     * @return DemandeSaveFiltres
     */
    public function setEntiteMetier($entiteMetier)
    {
        $this->entiteMetier = $entiteMetier;

        return $this;
    }

    /**
     * Get entiteMetier
     *
     * @return string
     */
    public function getEntiteMetier()
    {
        return $this->entiteMetier;
    }

    /**
     * Set typeProjet
     *
     * @param string $typeProjet
     *
     * @return DemandeSaveFiltres
     */
    public function setTypeProjet($typeProjet)
    {
        $this->typeProjet = $typeProjet;

        return $this;
    }

    /**
     * Get typeProjet
     *
     * @return string
     */
    public function getTypeProjet()
    {
        return $this->typeProjet;
    }

    /**
     * Set porteurMetier
     *
     * @param string $porteurMetier
     *
     * @return DemandeSaveFiltres
     */
    public function setPorteurMetier($porteurMetier)
    {
        $this->porteurMetier = $porteurMetier;

        return $this;
    }

    /**
     * Get porteurMetier
     *
     * @return string
     */
    public function getPorteurMetier()
    {
        return $this->porteurMetier;
    }

    /**
     * Set SDM
     *
     * @param string $SDM
     *
     * @return DemandeSaveFiltres
     */
    public function setSDM($SDM)
    {
        $this->SDM = $SDM;

        return $this;
    }

    /**
     * Get SDM
     *
     * @return string
     */
    public function getSDM()
    {
        return $this->SDM;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return DemandeSaveFiltres
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
     * Set utilisateur
     *
     * @param NIPA\UserBundle\Entity\Utilisateur $utilisateur
     *
     * @return DemandeSaveFiltres
     */
    public function setUtilisateur(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
    
    /**
     * Get utilisateur
     *
     * @return Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }    
    
}

