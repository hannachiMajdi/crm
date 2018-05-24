<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UsersBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Devis
 *
 * @ORM\Table(name="devis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DevisRepository")
 * @UniqueEntity(
 *     fields="ref",
 *     errorPath="ref",
 *     message="La référence existe déja !"
 * )
 */
class Devis
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
     * @ORM\Column(name="ref", type="string", length=255, unique=true)
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
     * @ORM\OneToMany(targetEntity="DevisProduit", mappedBy="devis", cascade={"persist", "remove"} )
     */
    private $devisProduits;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Service", mappedBy="deviss")
     */
    private $services;
    /**
     *
     * @ORM\OneToOne(targetEntity="Affaire", inversedBy="devis", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="affaire_id", referencedColumnName="id",nullable=true)
     */
    private $affaire;
    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\User", inversedBy="deviss")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;



    public function __construct(User $user) {

        $this->user = $user;
        $this->devisProduits = new ArrayCollection();
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
     * @return Devis
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
     * @param string $date
     *
     * @return Devis
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Add service
     *
     * @param \AppBundle\Entity\Service $service
     *
     * @return Devis
     */
    public function addService(\AppBundle\Entity\Service $service)
    {

        $this->services[] = $service;
        if (!$service->getDeviss()->contains($this)) {
            $service->addDevis($this);
        }

        return $this;
    }

    /**
     * Remove service
     *
     * @param \AppBundle\Entity\Service $service
     */
    public function removeService(\AppBundle\Entity\Service $service)
    {
        $this->services->removeElement($service);
        $service->removeDevis($this);
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
     * Add devisProduit
     *
     * @param \AppBundle\Entity\DevisProduit $devisProduit
     *
     * @return Devis
     */
    public function addDevisProduit(\AppBundle\Entity\DevisProduit $devisProduit)
    {
        $devisProduit->setDevis($this);
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
     * Set affaire
     *
     * @param \AppBundle\Entity\Affaire $affaire
     *
     * @return Devis
     */
    public function setAffaire(\AppBundle\Entity\Affaire $affaire = null)
    {
        $this->affaire = $affaire;

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
     * @return Devis
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
     * @return Devis
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
