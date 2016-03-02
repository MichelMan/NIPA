<?php
// src/NIPA/UserBundle/Entity/Utilisateur.php

namespace NIPA\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert; //Pour ajouter des contraintes / règles sur notre entité Utilisateur
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use FOS\UserBundle\Model\User as BaseUser;


/**
 * NIPA\UserBundle\Entity\Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="NIPA\UserBundle\Repository\UtilisateurRepository")
 * @UniqueEntity(fields="Identifiant", message="Cet identifiant existe déjà...")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email",
 *              type     = "string",
 *              length   = 255,
 *              nullable = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name     = "email_canonical",
 *              type     = "string",
 *              length   = 255,
 *              nullable = true
 *          )
 *      ),
 * })
 */



class Utilisateur extends BaseUser
{
   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;

 /**
     * @var string $Identifiant
     * @Assert\NotBlank(message="Identifiant must not be empty")
     * @Assert\Length(max=7)
     * @ORM\Column(name="Identifiant", type="string", length=25, unique=true)
     */
    private $Identifiant;

    /**
     * @var string $Prenom
     * @ORM\Column(name="Prenom", type="string", length=50, nullable=true)
     */
    private $Prenom;

    /**
     * @var string $Nom
     * @Assert\NotBlank()
     * @ORM\Column(name="Nom", type="string", length=50)
     */
    private $Nom;

    /**
     * @var boolean $Admin
     *
     * @ORM\Column(name="Admin", type="boolean")
     */
    private $Admin;   
     
    /**
     *@var datetime $createdAt
     * @Assert\DateTime()  
     * @ORM\Column(name="Created_At", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="Groupe", inversedBy="utilisateur")
     * @ORM\JoinTable(name="user_groupes")
     */
    private $groupe;
   
   /*****************************/
   
   public function __construct()
   {
       parent::__construct();
       // your own logic

       $this->Admin = false;
       
       $this->createdAt = new \DateTime('now');
        
       $this->groupe = new ArrayCollection(); // Collection de Groupe(s) du User
    
   }
   
   /*****************************/
   
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
     * Set Identifiant
     *
     * @param string $identifiant
     */
    public function setIdentifiant($identifiant)
    {
        $this->Identifiant = $identifiant;
    }

        /**
     * Get Identifiant
     *
     * @return string 
     */
    public function getIdentifiant()
    {
        return $this->Identifiant;
    }

    /**
     * Set Prenom
     *
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->Prenom = $prenom;
    }

    /**
     * Get Prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->Prenom;
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
     * Set Admin
     *
     * @param boolean $admin
     */
    public function setAdmin($admin)
    {
        $this->Admin = $admin;
    }

    /**
     * Get Admin
     *
     * @return boolean 
     */
    public function getAdmin()
    {
        return $this->Admin;
    }


    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add groupe
     *
     * @param \NIPA\UserBundle\Entity\Groupe $groupe
     */
    public function addGroupe(\NIPA\UserBundle\Entity\Groupe $groupe)
    {
        $this->groupe[] = $groupe;
        //$groupe->addUtilisateur($this);
        //$this->groupe[] = $groupe;
    }
    
    /**
     * Add groupe
     *
     * @param \NIPA\UserBundle\Entity\Groupe $groupe
     */
    public function addGroupes(\NIPA\UserBundle\Entity\Groupe $groupe)
    {
        //$this->groupe[] = $groupe;
        $groupe->addUtilisateur($this);
        $this->groupe[] = $groupe;
    }

    /**
     * Remove groupe
     *
     * @param \NIPA\UserBundle\Entity\Groupe $groupe
     */
    public function removeGroupes(\NIPA\UserBundle\Entity\Groupe $groupe)
    {
        //$this->groupe[] = $groupe;
        //$groupe->addUtilisateur($this);
        //$this->groupe[] = $groupe;
        $this->getGroupe()->removeElement($groupe);
    }
    
    /**
     * Set groupe
     *
     * @param \Doctrine\Common\Collections\Collection $groupe
     */
    public function setGroupe(\Doctrine\Common\Collections\Collection $groupe)
    {
        $this->groupe = $groupe;
    }
  
    /**
     * Get groupe
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupe()
    {
        return $this->groupe;
    }
    
    public function getGroupesToArray()
    {
        return $this->groupe->toArray();                
    }
    
}