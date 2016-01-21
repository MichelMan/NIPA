<?php

namespace NIPA\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NIPA\UserBundle\Entity\Groupe
 *
 * @ORM\Table(name="groupe")
 * @ORM\Entity(repositoryClass="NIPA\UserBundle\Repository\GroupeRepository")
 */
class Groupe
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $Nom
     *
     * @ORM\Column(name="Nom", type="string", length=55, unique=true)
     */
    private $Nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */    
    
    private $description;    
    
    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="groupe")
     */
    private $utilisateur;

    /**
     * @ORM\OneToOne(targetEntity="NIPA\UserBundle\Entity\Permission", cascade={"persist"})
     */
    private $permission;        
    
    
    public function __construct() {
        $this->utilisateur = new ArrayCollection();
    }
   
    
    public function setPermission(Permission $permission)
    {
      $this->permission = $permission;
    }

    public function getPermission()
    {
      return $this->permission;
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
     * Set Nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->Nom = $nom;
    }

    /**
     * Get Nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->Nom;
    }

    /**
     * Set description
     *
     * @param string $description
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
     * Add utilisateur
     *
     * @param \NIPA\UserBundle\Entity\Utilisateur $utilisateur
     */
    public function addUtilisateur(\NIPA\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur[] = $utilisateur;
    }    
    
    /**
     * Add utilisateur
     *
     * @param \NIPA\UserBundle\Entity\Utilisateur $utilisateur
     */
    public function addUtilisateurs(\NIPA\UserBundle\Entity\Utilisateur $utilisateur)
    {
        //$this->utilisateur[] = $utilisateur;
        $utilisateur->addGroupe($this);
        $this->utilisateur[] = $utilisateur;
    }

    /**
     * Remove utilisateur
     *
     * @param \NIPA\UserBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateurs(\NIPA\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->getUtilisateur()->removeElement($utilisateur);  
    }    
    
    /**
     * Set utilisateur
     *
     * @param \Doctrine\Common\Collections\Collection $utilisateur
     */
    public function setUtilisateur(\Doctrine\Common\Collections\Collection $utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }   
    
    /**
     * Get utilisateur
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;                
    }
    
    public function getUtilisateursToArray()
    {
        return $this->utilisateur->toArray();                
    }
}