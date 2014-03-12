<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="seuil")
 */
class Seuil
{
    /**
     * @var Id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
    }

    /**
     * @var Seuil
     * @ORM\Column(type="decimal")
     */
    protected $seuil;

    /**
     * @ORM\ManyToOne(targetEntity="Compte", inversedBy="seuil", cascade={"remove"})
     * @ORM\JoinColumn(name="compte_id", referencedColumnName="id")
     */
    protected $compteId;


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
     * Set seuil
     *
     * @param string $seuil
     * @return Seuil
     */
    public function setSeuil($seuil)
    {
        $this->seuil = $seuil;

        return $this;
    }

    /**
     * Get seuil
     *
     * @return string 
     */
    public function getSeuil()
    {
        return $this->seuil;
    }

    /**
     * Set compteId
     *
     * @param \Acme\UserBundle\Entity\Compte $compteId
     * @return Seuil
     */
    public function setCompteId(\Acme\UserBundle\Entity\Compte $compteId = null)
    {
        $this->compteId = $compteId;

        return $this;
    }

    /**
     * Get compteId
     *
     * @return \Acme\UserBundle\Entity\Compte 
     */
    public function getCompteId()
    {
        return $this->compteId;
    }
}
