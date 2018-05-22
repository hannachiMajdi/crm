<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UsersBundle\Entity\User;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=255, unique=true, nullable=true)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixUnit", type="float")
     */
    private $prixUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="CommandeProduit", mappedBy="produit", fetch="EXTRA_LAZY")
     */
    private $commandeProduits;

    /**
     * @ORM\OneToMany(targetEntity="DevisProduit", mappedBy="produit", fetch="EXTRA_LAZY")
     */
    private $devisProduits;
    /**
     * @ORM\OneToMany(targetEntity="FactureProduit", mappedBy="produit", fetch="EXTRA_LAZY")
     */
    private $factureProduits;
    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\User", inversedBy="produits")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;



    public function __construct(User $user) {
        $this->user = $user;
        $this->commandeProduits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devisProduits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->factureProduits = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function __toString()
    {
       return $this->ref.' - '.$this->nom;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ref
     *
     * @param string $ref
     *
     * @return Produit
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Produit
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
     * Set prixUnit
     *
     * @param string $prixUnit
     *
     * @return Produit
     */
    public function setPrixUnit($prixUnit)
    {
        $this->prixUnit = $prixUnit;

        return $this;
    }

    /**
     * Get prixUnit
     *
     * @return string
     */
    public function getPrixUnit()
    {
        return $this->prixUnit;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Produit
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
     * Add commandeProduit
     *
     * @param \AppBundle\Entity\CommandeProduit $commandeProduit
     *
     * @return Produit
     */
    public function addCommandeProduit(\AppBundle\Entity\CommandeProduit $commandeProduit)
    {
        $this->commandeProduits[] = $commandeProduit;

        return $this;
    }

    /**
     * Remove commandeProduit
     *
     * @param \AppBundle\Entity\CommandeProduit $commandeProduit
     */
    public function removeCommandeProduit(\AppBundle\Entity\CommandeProduit $commandeProduit)
    {
        $this->commandeProduits->removeElement($commandeProduit);
    }

    /**
     * Get commandeProduits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandeProduits()
    {
        return $this->commandeProduits;
    }

    /**
     * Add devisProduit
     *
     * @param \AppBundle\Entity\DevisProduit $devisProduit
     *
     * @return Produit
     */
    public function addDevisProduit(\AppBundle\Entity\DevisProduit $devisProduit)
    {
        $this->devisProduits[] = $devisProduit;

        return $this;
    }

    /**
     * Remove devisProduit
     *
     * @param \AppBundle\Entity\DevisProduit $devisProduit
     */
    public function removeDevisProduit(\AppBundle\Entity\DevisProduit $devisProduit)
    {
        $this->devisProduits->removeElement($devisProduit);
    }

    /**
     * Get devisProduits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisProduits()
    {
        return $this->devisProduits;
    }

    /**
     * Add factureProduit
     *
     * @param \AppBundle\Entity\FactureProduit $factureProduit
     *
     * @return Produit
     */
    public function addFactureProduit(\AppBundle\Entity\FactureProduit $factureProduit)
    {
        $this->factureProduits[] = $factureProduit;

        return $this;
    }

    /**
     * Remove factureProduit
     *
     * @param \AppBundle\Entity\FactureProduit $factureProduit
     */
    public function removeFactureProduit(\AppBundle\Entity\FactureProduit $factureProduit)
    {
        $this->factureProduits->removeElement($factureProduit);
    }

    /**
     * Get factureProduits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactureProduits()
    {
        return $this->factureProduits;
    }

    /**
     * Set user
     *
     * @param \UsersBundle\Entity\User $user
     *
     * @return Produit
     */
    public function setUser(\UsersBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UsersBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
