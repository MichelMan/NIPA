<?php

namespace NIPA\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permission
 *
 * @ORM\Table(name="groupe_permission")
 * @ORM\Entity(repositoryClass="NIPA\UserBundle\Entity\PermissionRepository")
 */
class Permission
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
     * @var boolean
     *
     * @ORM\Column(name="CMS_Portefeuille", type="boolean")
     */
    private $CMSPortefeuille;

    /**
     * @var boolean
     *
     * @ORM\Column(name="L_Portefeuille", type="boolean")
     */
    private $LPortefeuille;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CMS_Demande", type="boolean")
     */
    private $CMSDemande;

    /**
     * @var boolean
     *
     * @ORM\Column(name="L_Demande", type="boolean")
     */
    private $LDemande;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CMS_Projet", type="boolean")
     */
    private $CMSProjet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="L_Projet", type="boolean")
     */
    private $LProjet;

    
    public function __construct()
    {
            $this->CMSPortefeuille = false;
            $this->LPortefeuille = false;
            $this->CMSDemande = false;
            $this->LDemande = false;
            $this->CMSProjet = false;
            $this->LProjet = false;   
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
     * Set CMSPortefeuille
     *
     * @param boolean $CMSPortefeuille
     *
     * @return Permission
     */
    public function setCMSPortefeuille($CMSPortefeuille)
    {
        $this->CMSPortefeuille = $CMSPortefeuille;

        return $this;
    }

    /**
     * Get CMSPortefeuille
     *
     * @return boolean
     */
    public function getCMSPortefeuille()
    {
        return $this->CMSPortefeuille;
    }

    /**
     * Set LPortefeuille
     *
     * @param boolean $LPortefeuille
     *
     * @return Permission
     */
    public function setLPortefeuille($LPortefeuille)
    {
        $this->LPortefeuille = $LPortefeuille;

        return $this;
    }

    /**
     * Get LPortefeuille
     *
     * @return boolean
     */
    public function getLPortefeuille()
    {
        return $this->LPortefeuille;
    }

    /**
     * Set CMSDemande
     *
     * @param boolean $CMSDemande
     *
     * @return Permission
     */
    public function setCMSDemande($CMSDemande)
    {
        $this->CMSDemande = $CMSDemande;

        return $this;
    }

    /**
     * Get CMSDemande
     *
     * @return boolean
     */
    public function getCMSDemande()
    {
        return $this->CMSDemande;
    }

    /**
     * Set LDemande
     *
     * @param boolean $LDemande
     *
     * @return Permission
     */
    public function setLDemande($LDemande)
    {
        $this->LDemande = $LDemande;

        return $this;
    }

    /**
     * Get LDemande
     *
     * @return boolean
     */
    public function getLDemande()
    {
        return $this->LDemande;
    }

    /**
     * Set CMSProjet
     *
     * @param boolean $CMSProjet
     *
     * @return Permission
     */
    public function setCMSProjet($CMSProjet)
    {
        $this->CMSProjet = $CMSProjet;

        return $this;
    }

    /**
     * Get CMSProjet
     *
     * @return boolean
     */
    public function getCMSProjet()
    {
        return $this->CMSProjet;
    }

    /**
     * Set LProjet
     *
     * @param boolean $LProjet
     *
     * @return Permission
     */
    public function setLProjet($LProjet)
    {
        $this->LProjet = $LProjet;

        return $this;
    }

    /**
     * Get LProjet
     *
     * @return boolean
     */
    public function getLProjet()
    {
        return $this->LProjet;
    }
}

