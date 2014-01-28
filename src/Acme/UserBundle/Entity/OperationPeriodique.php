<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="op_periodique")
 */
class OperationPeriodique
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
        $this->features = new ArrayCollection();
    }

    /**
     * @var Nom
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @var Date
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @var Compte
     * @ORM\ManyToOne(targetEntity="Compte")
     **/
    protected $compte;

    /**
     * @var Type
     * @ORM\Column(type="integer", length=1)
     */
    protected $type;

    /**
     * @var Montant
     * @ORM\Column(type="decimal")
     */
    protected $montant;

    /**
     * @var OperationBancaire
     * @ORM\OneToMany(targetEntity="OperationBancaire", mappedBy="operationPeriodique")
     **/
    protected $operationBancaire;

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
     * Set nom
     *
     * @param string $nom
     * @return OperationPeriodique
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
     * Set date
     *
     * @param \DateTime $date
     * @return OperationPeriodique
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return OperationPeriodique
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set montant
     *
     * @param string $montant
     * @return OperationPeriodique
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set compte
     *
     * @param \Acme\UserBundle\Entity\Compte $compte
     * @return OperationPeriodique
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

    /**
     * Add operationBancaire
     *
     * @param \Acme\UserBundle\Entity\OperationBancaire $operationBancaire
     * @return OperationPeriodique
     */
    public function addOperationBancaire(\Acme\UserBundle\Entity\OperationBancaire $operationBancaire)
    {
        $this->operationBancaire[] = $operationBancaire;

        return $this;
    }

    /**
     * Remove operationBancaire
     *
     * @param \Acme\UserBundle\Entity\OperationBancaire $operationBancaire
     */
    public function removeOperationBancaire(\Acme\UserBundle\Entity\OperationBancaire $operationBancaire)
    {
        $this->operationBancaire->removeElement($operationBancaire);
    }

    /**
     * Get operationBancaire
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperationBancaire()
    {
        return $this->operationBancaire;
    }
}
