<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UsersBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 * @UniqueEntity(
 *     fields="ref",
 *     errorPath="ref",
 *     message="La référence existe déja !"
 * )
 */
class Commande
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
     *      minMessage = "Mininmum 2 caractéres pour la référence long",
     *
     * )
     * @ORM\Column(name="ref", type="string", length=255)
     */
    private $ref;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="La date ne doit pas étre vide !")
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    /**
     * @var float
     *
     * @ORM\Column(name="prixtotal", type="float")
     */
    private $prixtotal;

    /**
     * @ORM\OneToMany(targetEntity="CommandeProduit", mappedBy="commande", cascade={"persist", "remove", "merge"} )
     */
    private $commandeProduits;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Service", mappedBy="commandes", cascade={"persist", "remove", "merge"} )
     */
    private $services;
    /**
     *
     * @ORM\OneToOne(targetEntity="Affaire", mappedBy="commande", cascade={"persist", "remove"} )
     */
    private $affaire;
    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\User", inversedBy="commandes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $user;



    public function __construct(User $user) {

        $this->user = $user;
        $this->commandeProduits = new ArrayCollection();
        $this->services = new ArrayCollection();
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
     * @return Commande
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
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
     * Add commandeProduit
     *
     * @param \AppBundle\Entity\CommandeProduit $commandeProduit
     *
     * @return Commande
     */
    public function addCommandeProduit(\AppBundle\Entity\CommandeProduit $commandeProduit)
    {
        $this->commandeProduits[] = $commandeProduit;
        $commandeProduit->setCommande($this);

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
     * Add service
     *
     * @param \AppBundle\Entity\Service $service
     *
     * @return Commande
     */
    public function addService(\AppBundle\Entity\Service $service)
    {
        $this->services[] = $service;
        if (!$service->getCommandes()->contains($this)) {
            $service->addCommande($this);
        }

        return $this;
    }


    public function removeService(\AppBundle\Entity\Service $service)
    {
       return $this->services->removeElement($service);
        //$service->removeCommande($this);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set affaire
     *
     * @param \AppBundle\Entity\Affaire $affaire
     *
     * @return Commande
     */
    public function setAffaire(\AppBundle\Entity\Affaire $affaire = null)
    {
        $this->affaire = $affaire;
        $affaire->setCommande($this);

        return $this;
    }

    /**
     * Get affaire
     *
     * @return \AppBundle\Entity\Affaire
     */
    public function getAffaire()
    {
        return $this->affaire;
    }

    /**
     * Set user
     *
     * @param \UsersBundle\Entity\User $user
     *
     * @return Commande
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
     * Set prixtotal
     *
     * @param float $prixtotal
     *
     * @return Commande
     */
    public function setPrixtotal($prixtotal)
    {
        $this->prixtotal = $prixtotal;

        return $this;
    }

    /**
     * Get prixtotal
     *
     * @return float
     */
    public function getPrixtotal()
    {
        return $this->prixtotal;
    }
}
