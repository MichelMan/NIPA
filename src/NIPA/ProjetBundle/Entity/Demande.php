<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\DemandeRepository")
 */
class Demande
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
     * @ORM\Column(name="Reference_Demande", type="string", length=25)
     */
    private $referenceDemande;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandePriorite")
     * @ORM\JoinColumn(name="demande_priorite_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $priorite;

    /**
     * @var string
     *
     * @ORM\Column(name="Type_Enveloppe", type="string", length=50, nullable=true)
     */
    private $typeEnveloppe; 
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Commentaires", type="string", length=2500, nullable=true)
     */
    private $commentaires;

    
    /**
     * @var string
     *
     * @ORM\Column(name="phaseDemandeEnCours", type="string", length=25, nullable=true)
     */
    private $phaseProjetEnCours;

    /**
     * @var string
     *
     * @ORM\Column(name="phaseDemandeEnCoursMAJ", type="string", length=25, nullable=true)
     */
    private $phaseProjetEnCoursMAJ;    
    
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
     * @var string
     *
     * @ORM\Column(name="TTD_Souhaite", type="string", length=25, nullable=true)
     */
    private $TTDSouhaite;
    
    /**
     * @var string
     *
     * @ORM\Column(name="TTD_Souhaite_Revise", type="string", length=25, nullable=true)
     */
    private $TTDSouhaiteRevise;
    
    /**
     * @var string
     *
     * @ORM\Column(name="TTD_Projets", type="string", length=25, nullable=true)
     */
    private $TTDProjets;
    
    /**
     * @var string
     *
     * @ORM\Column(name="TTD_Projets_Revises", type="string", length=25, nullable=true)
     */
    private $TTDProjetsRevises;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="Nb_Lots", type="integer")
     */
    private $nbLots;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeDirection")
     * @ORM\JoinColumn(name="demande_direction_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $direction;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeEntiteMetier")
     * @ORM\JoinColumn(name="demande_entite_metier_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $entiteMetier;        

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeOffres")
     * @ORM\JoinColumn(name="demande_offres_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $offres;     
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeTypeProjet")
     * @ORM\JoinColumn(name="demande_type_projet_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $typeProjet;     
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeDivers")
     * @ORM\JoinColumn(name="demande_divers_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $divers;         
    
    /**
     * @ORM\ManyToMany(targetEntity="NIPA\ProjetBundle\Entity\Portefeuille", mappedBy="demande")
     */
    private $portefeuilles;

    /**
     * @var string
     *
     * @ORM\Column(name="Date_Cloture", type="string", length=25, nullable=true)
     */
    private $dateCloture;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeStatut")
     * @ORM\JoinColumn(name="demande_statut_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $demandeStatut;

    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandePorteurMetier")
     * @ORM\JoinColumn(name="demande_porteur_metier_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $porteurMetier;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeInterlocuteurMOA")
     * @ORM\JoinColumn(name="demande_interlocuteur_MOA_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $interlocuteurMOA;
    
    /**
     * @ORM\ManyToOne(targetEntity="NIPA\ProjetBundle\Entity\DemandeSDM")
     * @ORM\JoinColumn(name="demande_SDM_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $SDM;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="REX", type="boolean")
     */
    private $REX;    
    
    
    /**********Description et Enjeux*************/
    /**
     * @var string
     *
     * @ORM\Column(name="Contexte", type="string", length=2500, nullable= true)
     */
    private $contexte;

    /**
     * @var string
     *
     * @ORM\Column(name="Enjeux", type="string", length=2500, nullable= true)
     */
    private $enjeux;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarques", type="string", length=2500, nullable= true)
     */
    private $remarques;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=2500, nullable= true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="ROI", type="float", nullable= true)
     */
    private $ROI;
    /***********************/
    
    public function __construct()
    {
        $this->portefeuilles = new ArrayCollection();
        $this->nbLots = 0;
        $this->REX = false;
    }
    
    
    /*********************GETTERS AND SETTERS**************************/
    
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
     * Set referenceDemande
     *
     * @param string $referenceDemande
     *
     * @return Demande
     */
    public function setReferenceDemande($referenceDemande)
    {
        $this->referenceDemande = $referenceDemande;

        return $this;
    }

    /**
     * Get referenceDemande
     *
     * @return string
     */
    public function getReferenceDemande()
    {
        return $this->referenceDemande;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Demande
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
     * Set typeEnveloppe
     *
     * @param string $typeEnveloppe
     *
     * @return Demande
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
     * Set priorite
     *
     * @param DemandePriorite $priorite
     *
     * @return Demande
     */
    public function setPriorite(DemandePriorite $priorite)
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
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Demande
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
     * Get phaseDemandeEnCours
     *
     * @return string
     */
    public function getPhaseDemandeEnCours()
    {
        return $this->phaseProjetEnCours;
    }

    /**
     * Set phaseProjetEnCours
     *
     * @param string $phaseProjetEnCours
     *
     * @return Demande
     */
    public function setPhaseDemandeEnCours($phaseProjetEnCours)
    {
        $this->phaseProjetEnCours = $phaseProjetEnCours;

        return $this;
    }

    /**
     * Get phaseDemandeEnCoursMAJ
     *
     * @return string
     */
    public function getPhaseDemandeEnCoursMAJ()
    {
        return $this->phaseProjetEnCoursMAJ;
    }

    /**
     * Set phaseProjetEnCoursMAJ
     *
     * @param string $phaseProjetEnCoursMAJ
     *
     * @return Demande
     */
    public function setPhaseDemandeEnCoursMAJ($phaseProjetEnCoursMAJ)
    {
        $this->phaseProjetEnCoursMAJ = $phaseProjetEnCoursMAJ;

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
     * @return Demande
     */
    public function setBudgetEnCours($BudgetEnCours)
    {
        $this->BudgetEnCours = $BudgetEnCours;

        return $this;
    }    
    
    
    /**
     * Set dateMEP
     *
     * @param date $dateMEP
     *
     * @return Demande
     */
    public function setDateMEP($dateMEP)
    {
        $this->dateMEP = $dateMEP;

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
     * Set TTDSouhaite
     *
     * @param string $TTDSouhaite
     *
     * @return Demande
     */
    public function setTTDSouhaite($TTDSouhaite)
    {
        $this->TTDSouhaite = $TTDSouhaite;

        return $this;
    }

    /**
     * Get TTDSouhaite
     *
     * @return string
     */
    public function getTTDSouhaite()
    {
        return $this->TTDSouhaite;
    }
    
    
    /**
     * Set TTDSouhaiteRevise
     *
     * @param string $TTDSouhaiteRevise
     *
     * @return Demande
     */
    public function setTTDSouhaiteRevise($TTDSouhaiteRevise)
    {
        $this->TTDSouhaiteRevise = $TTDSouhaiteRevise;

        return $this;
    }

    /**
     * Get TTDSouhaiteRevise
     *
     * @return string
     */
    public function getTTDSouhaiteRevise()
    {
        return $this->TTDSouhaiteRevise;
    }
    
    
    /**
     * Set TTDProjets
     *
     * @param string $TTDProjets
     *
     * @return Demande
     */
    public function setTTDProjets($TTDProjets)
    {
        $this->TTDProjets = $TTDProjets;

        return $this;
    }

    /**
     * Get TTDProjets
     *
     * @return string
     */
    public function getTTDProjets()
    {
        return $this->TTDProjets;
    }
    
    
    /**
     * Set TTDProjetsRevises
     *
     * @param string $TTDProjetsRevises
     *
     * @return Demande
     */
    public function setTTDProjetsRevises($TTDProjetsRevises)
    {
        $this->TTDProjetsRevises = $TTDProjetsRevises;

        return $this;
    }

    /**
     * Get TTDProjetsRevises
     *
     * @return string
     */
    public function getTTDProjetsRevises()
    {
        return $this->TTDProjetsRevises;
    }
    
 
    /**
     * Set nbLots
     *
     * @param integer $nbLots
     *
     * @return Demande
     */
    public function setNbLots($nbLots)
    {
        $this->nbLots = $nbLots;

        return $this;
    }

    /**
     * Get nbLots
     *
     * @return integer
     */
    public function getNbLots()
    {
        return $this->nbLots;
    }
   
    
    /**
     * Set direction
     *
     * @param DemandeDirection $direction
     *
     * @return Demande
     */
    public function setDirection(DemandeDirection $direction)
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
     * @param DemandeEntiteMetier $entiteMetier
     *
     * @return Demande
     */
    public function setEntiteMetier(DemandeEntiteMetier $entiteMetier)
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
     * @param DemandeOffres $offres
     *
     * @return Demande
     */
    public function setOffres(DemandeOffres $offres)
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
     * @param DemandeTypeProjet $typeProjet
     *
     * @return Demande
     */
    public function setTypeProjet(DemandeTypeProjet $typeProjet)
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
     * @param DemandeDivers $divers
     *
     * @return Demande
     */
    public function setDivers(DemandeDivers $divers)
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
     * Set dateCloture
     *
     * @param string $dateCloture
     *
     * @return Demande
     */
    public function setDateCloture($dateCloture)
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    /**
     * Get dateCloture
     *
     * @return string
     */
    public function getDateCloture()
    {
        return $this->dateCloture;
    }

    /**
     * Set demandeStatut
     *
     * @param DemandeStatut $demandeStatut
     *
     * @return Demande
     */
    public function setDemandeStatut(DemandeStatut $demandeStatut)
    {
        $this->demandeStatut = $demandeStatut;

        return $this;
    }

    /**
     * Get demandeStatut
     *
     * @return string
     */
    public function getDemandeStatut()
    {
        return $this->demandeStatut;
    }
    
   /**
     * Set porteurMetier
     *
     * @param DemandePorteurMetier $porteurMetier
     *
     * @return Demande
     */
    public function setPorteurMetier(DemandePorteurMetier $porteurMetier)
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
     * Set interlocuteurMOA
     *
     * @param DemandeInterlocuteurMOA $interlocuteurMOA
     *
     * @return Demande
     */
    public function setInterlocuteurMOA(DemandeInterlocuteurMOA $interlocuteurMOA)
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
     * Set SDM
     *
     * @param DemandeSDM $SDM
     *
     * @return Demande
     */
    public function setSDM(DemandeSDM $SDM)
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
     * Set REX
     *
     * @param boolean $REX
     *
     * @return Demande
     */
    public function setREX($REX)
    {
        $this->REX = $REX;

        return $this;
    }

    /**
     * Get REX
     *
     * @return boolean
     */
    public function getREX()
    {
        return $this->REX;
    }  
    
    /*************Description et Enjeux***************/
    
    /**
     * Set contexte
     *
     * @param string $contexte
     *
     * @return Demande
     */
    public function setContexte($contexte)
    {
        $this->contexte = $contexte;

        return $this;
    }

    /**
     * Get contexte
     *
     * @return string
     */
    public function getContexte()
    {
        return $this->contexte;
    }

    /**
     * Set enjeux
     *
     * @param string $enjeux
     *
     * @return Demande
     */
    public function setEnjeux($enjeux)
    {
        $this->enjeux = $enjeux;

        return $this;
    }

    /**
     * Get enjeux
     *
     * @return string
     */
    public function getEnjeux()
    {
        return $this->enjeux;
    }
    
    /**
     * Set remarques
     *
     * @param string $remarques
     *
     * @return Demande
     */
    public function setRemarques($remarques)
    {
        $this->remarques = $remarques;

        return $this;
    }

    /**
     * Get remarques
     *
     * @return string
     */
    public function getRemarques()
    {
        return $this->remarques;
    }
    
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Demande
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
     * Set ROI
     *
     * @param string $ROI
     *
     * @return Demande
     */
    public function setROI($ROI)
    {
        $this->ROI = $ROI;

        return $this;
    }

    /**
     * Get ROI
     *
     * @return string
     */
    public function getROI()
    {
        return $this->ROI;
    }    
    
    /***************************/
    
  /**
     * Add portefeuille
     *
     * @param \NIPA\ProjetBundle\Entity\Portefeuille $portefeuille
     */
    public function addPortefeuille(\NIPA\ProjetBundle\Entity\Portefeuille $portefeuille)
    {
        $this->portefeuilles[] = $portefeuille;
    }    
    
    /**
     * Add portefeuille
     *
     * @param \NIPA\ProjetBundle\Entity\Portefeuille $portefeuille
     */
    public function addPortefeuilles(\NIPA\ProjetBundle\Entity\Portefeuille $portefeuille)
    {
        //$this->utilisateur[] = $utilisateur;
        $portefeuille->addDemande($this);
        $this->portefeuilles[] = $portefeuille;
    }


    public function removePortefeuilles(Portefeuille $portefeuille)
    {
        $this->portefeuilles->removeElement($portefeuille);
    }

    public function getPortefeuille()
    {
        return $this->portefeuilles;
    }
     
    /**
     * Set Portefeuille
     *
     * @param \Doctrine\Common\Collections\Collection $portefeuille
     */
    public function setPortefeuille(\Doctrine\Common\Collections\Collection $portefeuille)
    {
        $this->portefeuilles = $portefeuille;
    }  
    
    /**
     * Get portefeuille
     *
     * @return \Doctrine\Common\Collections\Collection 
     */    
    public function getPortefeuillesToArray()
    {
        return $this->portefeuilles->toArray();                
    }     
    
}

