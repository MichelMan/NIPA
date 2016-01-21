<?php

namespace NIPA\ProjetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeDivers
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NIPA\ProjetBundle\Repository\DemandeDiversRepository")
 */
class DemandeDivers
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
     * @ORM\Column(name="Valeur", type="string", length=50)
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
     * @return DemandeDivers
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

