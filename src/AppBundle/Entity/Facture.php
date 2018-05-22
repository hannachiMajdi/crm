<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UsersBundle\Entity\User;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactureRepository")
 */
class Facture
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
     * @ORM\Column(name="ref", type="string", length=255)
     */
    private $ref;

    /**
     * @var \DateTime
     *
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
     * @ORM\OneToMany(targetEntity="FactureProduit", mappedBy="facture", cascade={"persist"} )
     */
    private $factureProduits;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Service", mappedBy="factures", cascade={"persist"})
     */
    private $services;
    /**
     *
     * @ORM\OneToOne(targetEntity="Affaire", mappedBy="facture")
     */
    private $affaire;
    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\User", inversedBy="factures")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;



    public function __construct(User $user) {

        $this->user = $user;
        $this->factureProduits = new ArrayCollection();
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
     * @return Facture
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
     * @return Facture
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
     * @return Facture
     */
    public function addService(\AppBundle\Entity\Service $service)
    {

        $this->services[] = $service;
        if (!$service->getFactures()->contains($this)) {
            $service->addFacture($this);
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
        $service->removeFacture($this);
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
     * Add FactureProduit
     *
     * @param \AppBundle\Entity\FactureProduit $factureProduit
     *
     * @return Facture
     */
    public function addFactureProduit(\AppBundle\Entity\FactureProduit $factureProduit)
    {
        $factureProduit->setFacture($this);
        $this->factureProduits[] = $factureProduit;


        return $this;
    }

    /**
     * Remove factureProduit
     *
     * @param \AppBundle\Entity\FactureProduit $factureProduit
     */
    public function removefactureProduit(\AppBundle\Entity\FactureProduit $factureProduit)
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
     * Set affaire
     *
     * @param \AppBundle\Entity\Affaire $affaire
     *
     * @return Facture
     */
    public function setAffaire(\AppBundle\Entity\Affaire $affaire = null)
    {
        $this->affaire = $affaire;
        $affaire->setFacture($this);

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
     * @return Facture
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
     * @return Facture
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
