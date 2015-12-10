<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortefeuilleAnnee
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Entity\PortefeuilleAnneeRepository")
 */
class PortefeuilleAnnee
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
     * @ORM\Column(name="Valeur", type="string", length=25)
     */
    private $valeur;


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
     * Set valeur
     *
     * @param string $valeur
     *
     * @return PortefeuilleAnnee
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }
}

