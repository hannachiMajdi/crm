<?php
// src/AppBundle/Entity/User.php

namespace UsersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(
 *     fields="usernameCanonical",
 *     errorPath="username",
 *     message="Le pseudo existe déja !"
 * )
 * @UniqueEntity(
 *     fields="emailCanonical",
 *     errorPath="email",
 *     message="l'email exisite déja  !"
 * )
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Contact", mappedBy="user", cascade={"persist", "remove"})
     */
    private $contact;
    /**
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\InfoMailing", mappedBy="user", cascade={"persist", "remove"})
     */
    private $mailing;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Affaire", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $affaires;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commande", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $commandes;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Devis", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $deviss;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Facture", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $factures;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Produit", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $produits;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Service", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $services;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TicketClient", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $ticketClients;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Prospect", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $prospects;




    public function __construct()
    {
        parent::__construct();
        $this->affaires = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->deviss = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->ticketClients = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->prospects = new ArrayCollection();

    }

    /**
     * Set contact
     *
     * @param \AppBundle\Entity\Contact $contact
     *
     * @return User
     */
    public function setContact(\AppBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \AppBundle\Entity\Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set mailing
     *
     * @param \AppBundle\Entity\infoMailing $mailing
     *
     * @return User
     */
    public function setMailing(\AppBundle\Entity\infoMailing $mailing = null)
    {
        $this->mailing = $mailing;

        return $this;
    }

    /**
     * Get mailing
     *
     * @return \AppBundle\Entity\infoMailing
     */
    public function getMailing()
    {
        return $this->mailing;
    }

    /**
     * Add affaire
     *
     * @param \AppBundle\Entity\Affaire $affaire
     *
     * @return User
     */
    public function addAffaire(\AppBundle\Entity\Affaire $affaire)
    {

        $this->affaires[] = $affaire;

        return $this;
    }

    /**
     * Remove affaire
     *
     * @param \AppBundle\Entity\Affaire $affaire
     */
    public function removeAffaire(\AppBundle\Entity\Affaire $affaire)
    {
        $this->affaires->removeElement($affaire);
    }

    /**
     * Get affaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAffaires()
    {
        return $this->affaires;
    }

    /**
     * Add commande
     *
     * @param \AppBundle\Entity\Commande $commande
     *
     * @return User
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
     * Add deviss
     *
     * @param \AppBundle\Entity\Devis $deviss
     *
     * @return User
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
     * @return User
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
     * Add produit
     *
     * @param \AppBundle\Entity\Produit $produit
     *
     * @return User
     */
    public function addProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \AppBundle\Entity\Produit $produit
     */
    public function removeProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produits->removeElement($produit);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * Add service
     *
     * @param \AppBundle\Entity\Service $service
     *
     * @return User
     */
    public function addService(\AppBundle\Entity\Service $service)
    {
        $this->services[] = $service;

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
     * Add ticketClient
     *
     * @param \AppBundle\Entity\TicketClient $ticketClient
     *
     * @return User
     */
    public function addTicketClient(\AppBundle\Entity\TicketClient $ticketClient)
    {
        $this->ticketClients[] = $ticketClient;

        return $this;
    }

    /**
     * Remove ticketClient
     *
     * @param \AppBundle\Entity\TicketClient $ticketClient
     */
    public function removeTicketClient(\AppBundle\Entity\TicketClient $ticketClient)
    {
        $this->ticketClients->removeElement($ticketClient);
    }

    /**
     * Get ticketClients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTicketClients()
    {
        return $this->ticketClients;
    }


    /**
     * roles
     */
    public  function getRoleName(){
        $role = '';
        if($this->hasRole('ROLE_ADMIN')) $role .=' Administrateur ';
        if($this->hasRole('ROLE_COMMERCIAL')) $role .=' Commercial ';
        if($this->hasRole('ROLE_VENTE')) $role .=' Vente ';
        return $role;

    }

    /**
     * Add prospect
     *
     * @param \AppBundle\Entity\Prospect $prospect
     *
     * @return User
     */
    public function addProspect(\AppBundle\Entity\Prospect $prospect)
    {
        $this->prospects[] = $prospect;

        return $this;
    }

    /**
     * Remove prospect
     *
     * @param \AppBundle\Entity\Prospect $prospect
     */
    public function removeProspect(\AppBundle\Entity\Prospect $prospect)
    {
        $this->prospects->removeElement($prospect);
    }

    /**
     * Get prospects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProspects()
    {
        return $this->prospects;
    }
}
