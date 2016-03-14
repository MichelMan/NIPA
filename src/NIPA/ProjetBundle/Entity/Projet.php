<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Projet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\ProjetRepository")
 */
class Projet
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
     * @ORM\Column(name="Reference_Projet", type="string", length=50)
     */
    private $referenceProjet;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\Demande")
     */
    private $demande;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="titreLot", type="string", length=50, nullable=true)
     */
    private $titreLot;

    /**
     * @var string
     *
     * @ORM\Column(name="enveloppe", type="string", length=50, nullable=true)
     */
    private $enveloppe;

    /**
     * @var string
     *
     * @ORM\Column(name="priorite", type="string", length=25, nullable=true)
     */
    private $priorite;

    /**
     * @var string
     *
     * @ORM\Column(name="direction", type="string", length=50)
     */
    private $direction;

    /**
     * @var string
     *
     * @ORM\Column(name="entiteMetier", type="string", length=25)
     */
    private $entiteMetier;

    /**
     * @var string
     *
     * @ORM\Column(name="offres", type="string", length=25)
     */
    private $offres;

    /**
     * @var string
     *
     * @ORM\Column(name="typeProjet", type="string", length=50)
     */
    private $typeProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="divers", type="string", length=50, nullable=true)
     */
    private $divers;

    /**
     * @var string
     *
     * @ORM\Column(name="interlocuteurMOA", type="string", length=50, nullable=true)
     */
    private $interlocuteurMOA;

    /**
     * @var string
     *
     * @ORM\Column(name="porteurMetier", type="string", length=50, nullable=true)
     */
    private $porteurMetier;

    /**
     * @var string
     *
     * @ORM\Column(name="SDM", type="string", length=50, nullable=true)
     */
    private $SDM;

    /**
     * @var boolean
     *
     * @ORM\Column(name="devSI", type="boolean")
     */
    private $devSI;

    /**
     * @var boolean
     *
     * @ORM\Column(name="devRZO", type="boolean")
     */
    private $devRZO;

    /**
     * @var string
     *
     * @ORM\Column(name="indicateur", type="string", length=25, nullable=true)
     */
    private $indicateur;

    /**
     * @var string
     *
     * @ORM\Column(name="phaseProjet", type="string", length=25, nullable=true)
     */
    private $phaseProjet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="annuler", type="boolean")
     */
    private $annuler;

    /**
     * @var boolean
     *
     * @ORM\Column(name="suspendre", type="boolean")
     */
    private $suspendre;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="string", length=2500, nullable=true)
     */
    private $commentaires;

    /**
     * @var string
     *
     * @ORM\Column(name="alerte", type="string", length=2500, nullable=true)
     */
    private $alerte;

    /**
     * @var boolean
     *
     * @ORM\Column(name="escalade", type="boolean")
     */
    private $escalade;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lotissement", type="boolean")
     */
    private $lotissement;

    /**
     * @var string
     *
     * @ORM\Column(name="phaseProjetEnCours", type="string", length=25, nullable=true)
     */
    private $phaseProjetEnCours;
    
    /**
     * @var string
     *
     * @ORM\Column(name="BudgetEnCours", type="float", nullable=true)
     */
    private $BudgetEnCours;
    
    /**
     * @var date
     *
     * @ORM\Column(name="dateMEP", type="date", nullable=true)
     */
    private $dateMEP;
    
    
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
     * Set referenceProjet
     *
     * @param string $referenceProjet
     *
     * @return Projet
     */
    public function setReferenceProjet($referenceProjet)
    {
        $this->referenceProjet = $referenceProjet;

        return $this;
    }

    /**
     * Get referenceProjet
     *
     * @return string
     */
    public function getReferenceProjet()
    {
        return $this->referenceProjet;
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
    

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Projet
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
     * Set titreLot
     *
     * @param string $titreLot
     *
     * @return Projet
     */
    public function setTitreLot($titreLot)
    {
        $this->titreLot = $titreLot;

        return $this;
    }

    /**
     * Get titreLot
     *
     * @return string
     */
    public function getTitreLot()
    {
        return $this->titreLot;
    }

    /**
     * Set enveloppe
     *
     * @param string $enveloppe
     *
     * @return Projet
     */
    public function setEnveloppe($enveloppe)
    {
        $this->enveloppe = $enveloppe;

        return $this;
    }

    /**
     * Get enveloppe
     *
     * @return string
     */
    public function getEnveloppe()
    {
        return $this->enveloppe;
    }

    /**
     * Set priorite
     *
     * @param string $priorite
     *
     * @return Projet
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
     * Set direction
     *
     * @param string $direction
     *
     * @return Projet
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
     * Set entiteMetier
     *
     * @param string $entiteMetier
     *
     * @return Projet
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
     * Set offres
     *
     * @param string $offres
     *
     * @return Projet
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
     * Set typeProjet
     *
     * @param string $typeProjet
     *
     * @return Projet
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
     * Set divers
     *
     * @param string $divers
     *
     * @return Projet
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
     * @return Projet
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
     * Set porteurMetier
     *
     * @param string $porteurMetier
     *
     * @return Projet
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
     * @return Projet
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
     * Set devSI
     *
     * @param boolean $devSI
     *
     * @return Projet
     */
    public function setDevSI($devSI)
    {
        $this->devSI = $devSI;

        return $this;
    }

    /**
     * Get devSI
     *
     * @return boolean
     */
    public function getDevSI()
    {
        return $this->devSI;
    }

    /**
     * Set devRZO
     *
     * @param boolean $devRZO
     *
     * @return Projet
     */
    public function setDevRZO($devRZO)
    {
        $this->devRZO = $devRZO;

        return $this;
    }

    /**
     * Get devRZO
     *
     * @return boolean
     */
    public function getDevRZO()
    {
        return $this->devRZO;
    }

    /**
     * Set indicateur
     *
     * @param string $indicateur
     *
     * @return Projet
     */
    public function setIndicateur($indicateur)
    {
        $this->indicateur = $indicateur;

        return $this;
    }

    /**
     * Get indicateur
     *
     * @return string
     */
    public function getIndicateur()
    {
        return $this->indicateur;
    }

    /**
     * Set phaseProjet
     *
     * @param string $phaseProjet
     *
     * @return Projet
     */
    public function setPhaseProjet($phaseProjet)
    {
        $this->phaseProjet = $phaseProjet;

        return $this;
    }

    /**
     * Get phaseProjet
     *
     * @return string
     */
    public function getPhaseProjet()
    {
        return $this->phaseProjet;
    }

    /**
     * Set annuler
     *
     * @param boolean $annuler
     *
     * @return Projet
     */
    public function setAnnuler($annuler)
    {
        $this->annuler = $annuler;

        return $this;
    }

    /**
     * Get annuler
     *
     * @return boolean
     */
    public function getAnnuler()
    {
        return $this->annuler;
    }

    /**
     * Set suspendre
     *
     * @param boolean $suspendre
     *
     * @return Projet
     */
    public function setSuspendre($suspendre)
    {
        $this->suspendre = $suspendre;

        return $this;
    }

    /**
     * Get suspendre
     *
     * @return boolean
     */
    public function getSuspendre()
    {
        return $this->suspendre;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Projet
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
     * Set alerte
     *
     * @param string $alerte
     *
     * @return Projet
     */
    public function setAlerte($alerte)
    {
        $this->alerte = $alerte;

        return $this;
    }

    /**
     * Get alerte
     *
     * @return string
     */
    public function getAlerte()
    {
        return $this->alerte;
    }

    /**
     * Set escalade
     *
     * @param boolean $escalade
     *
     * @return Projet
     */
    public function setEscalade($escalade)
    {
        $this->escalade = $escalade;

        return $this;
    }

    /**
     * Get escalade
     *
     * @return boolean
     */
    public function getEscalade()
    {
        return $this->escalade;
    }
    
    /**
     * Set lotissement
     *
     * @param boolean $lotissement
     *
     * @return Projet
     */
    public function setLotissement($lotissement)
    {
        $this->lotissement = $lotissement;

        return $this;
    }

    /**
     * Get lotissement
     *
     * @return boolean
     */
    public function getLotissement()
    {
        return $this->lotissement;
    }
    
    /**
     * Get phaseProjetEnCours
     *
     * @return string
     */
    public function getPhaseProjetEnCours()
    {
        return $this->phaseProjetEnCours;
    }

    /**
     * Set phaseProjetEnCours
     *
     * @param string $phaseProjetEnCours
     *
     * @return Projet
     */
    public function setPhaseProjetEnCours($phaseProjetEnCours)
    {
        $this->phaseProjetEnCours = $phaseProjetEnCours;

        return $this;
    }
    
    /**
     * Get BudgetEnCours
     *
     * @return float
     */
    public function getBudgetEnCours()
    {
        return $this->BudgetEnCours;
    }

    /**
     * Set BudgetEnCours
     *
     * @param float $BudgetEnCours
     *
     * @return Projet
     */
    public function setBudgetEnCours($BudgetEnCours)
    {
        $this->BudgetEnCours = $BudgetEnCours;

        return $this;
    }
    
    /**
     * Get dateMEP
     *
     * @return date
     */
    public function getDateMEP()
    {
        return $this->dateMEP;
    }

    /**
     * Set dateMEP
     *
     * @param date $dateMEP
     *
     * @return Projet
     */
    public function setDateMEP($dateMEP)
    {
        $this->dateMEP = $dateMEP;

        return $this;
    }
    
}

