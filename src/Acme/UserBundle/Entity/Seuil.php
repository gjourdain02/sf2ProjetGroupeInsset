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
     * @var Compte
     * @ORM\ManyToOne(targetEntity="Compte")
     **/
    protected $compte;


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
     * Set compte
     *
     * @param \Acme\UserBundle\Entity\Compte $compte
     * @return Seuil
     */
    public function setCompte(\Acme\UserBundle\Entity\Compte $compte = null)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get compte
     *
     * @return \Acme\UserBundle\Entity\Compte 
     */
    public function getCompte()
    {
        return $this->compte;
    }
}
