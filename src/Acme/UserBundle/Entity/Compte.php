<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity
 * @ORM\Table(name="cpt_bancaire")
 */
class Compte
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
     * @var Nom
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @var NumeroCompte
     * @ORM\Column(type="string")
     */
    protected $numeroCompte;


    /**
     * @ORM\OneToMany(targetEntity="OperationBancaire", mappedBy="compteId", cascade={"remove", "persist"})
     */
    protected $operationBancaire;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     **/
    protected $user;

    /**
     * @var Actif
     * @ORM\Column(type="boolean")
     */
    protected $actif = 1;

    /**
     * Get id
     *
     * @return integer 
     */
    

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('nom', new NotBlank());
        $metadata->addPropertyConstraint('nom', new Assert\Regex(array(
            'pattern' => '/^[a-zA-z0-9]+/',
            'message' => 'Le champ ne peut contenir que des caractères alphanumeriques',
        )));

        $metadata->addPropertyConstraint('numeroCompte', new NotBlank());
        $metadata->addPropertyConstraint('numeroCompte', new Assert\Regex(array(
            'pattern' => '/^[a-zA-z0-9]+/',
            'message' => 'Le champ ne peut contenir que des caractères alphanumeriques',
        )));
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
     * Set nom
     *
     * @param string $nom
     * @return Compte
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
     * Set numeroCompte
     *
     * @param string $numeroCompte
     * @return Compte
     */
    public function setNumeroCompte($numeroCompte)
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    /**
     * Get numeroCompte
     *
     * @return string 
     */
    public function getNumeroCompte()
    {
        return $this->numeroCompte;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Compte
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Add operationBancaire
     *
     * @param \Acme\UserBundle\Entity\OperationBancaire $operationBancaire
     * @return Compte
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

    /**
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Compte
     */
    public function setUser(\Acme\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
