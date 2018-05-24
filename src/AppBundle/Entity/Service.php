<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UsersBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 * @UniqueEntity(
 *     fields="ref",
 *     errorPath="ref",
 *     message="La référence existe déja !"
 * )
 */
class Service
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
     * @Assert\NotBlank(message="La référence ne doit pas étre vide !")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Mininmum 2 caractéres pour la référence long"
     * )
     * @ORM\Column(name="ref", type="string", length=255)
     */
    private $ref;

    /**
     * @var string
     * @Assert\NotBlank(message="Le nom ne doit pas étre vide !")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Mininmum 2 caractéres pour Le nom"
     * )
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     * @Assert\NotBlank(message="Le prix unitaire ne doit pas étre vide !")
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\User", inversedBy="services")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",nullable=true , onDelete="SET NULL")
     */
    private $user;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Devis", inversedBy="services", cascade={"persist", "remove", "merge"})
     *
     * @ORM\JoinTable(name="devis_service",
     *      joinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="devis_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    private $deviss;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Facture", inversedBy="services", cascade={"persist", "remove", "merge"})
     * @ORM\JoinTable(name="facture_service",
     *      joinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="devis_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    private $factures;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Commande", inversedBy="services", cascade={"persist", "remove", "merge"})
     * @ORM\JoinTable(name="commande_service",
     *      joinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="devis_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    private $commandes;



    public function __construct(User $user) {
        $this->user = $user;
        $this->commandes = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->deviss = new ArrayCollection();
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
     * @return Service
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
     * @return Service
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
     * Set prix
     *
     * @param float $prix
     *
     * @return Service
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Service
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
     * Add deviss
     *
     * @param \AppBundle\Entity\Devis $devis
     *
     * @return Service
     */
    public function addDevis(\AppBundle\Entity\Devis $devis)
    {
       // $devis->addService($this);
        $this->deviss[] = $devis;
        if (! $devis->getServices()->contains($this)) {
            $devis->addService($this);
        }

        return $this;
    }

    /**
     * Remove devis
     *
     * @param \AppBundle\Entity\Devis $devis
     */
    public function removeDevis(\AppBundle\Entity\Devis $devis)
    {
        $this->deviss->removeElement($devis);
    }

    /**
     * Get deviss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeviss()
    {
        return $this->deviss;
    }

    /**
     * Add facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Service
     */
    public function addFacture(\AppBundle\Entity\Facture $facture)
    {
        $this->factures[] = $facture;

        return $this;
    }

    /**
     * Remove facture
     *
     * @param \AppBundle\Entity\Facture $facture
     */
    public function removeFacture(\AppBundle\Entity\Facture $facture)
    {
        $this->factures->removeElement($facture);
    }

    /**
     * Get factures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactures()
    {
        return $this->factures;
    }

    /**
     * Add commande
     *
     * @param \AppBundle\Entity\Commande $commande
     *
     * @return Service
     */
    public function addCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \AppBundle\Entity\Commande $commande
     */
    public function removeCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Set user
     *
     * @param \UsersBundle\Entity\User $user
     *
     * @return Service
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

    /**
     * Add deviss
     *
     * @param \AppBundle\Entity\Devis $deviss
     *
     * @return Service
     */
    public function addDeviss(\AppBundle\Entity\Devis $deviss)
    {
        $this->deviss[] = $deviss;

        return $this;
    }

    /**
     * Remove deviss
     *
     * @param \AppBundle\Entity\Devis $deviss
     */
    public function removeDeviss(\AppBundle\Entity\Devis $deviss)
    {
        $this->deviss->removeElement($deviss);
    }
}
