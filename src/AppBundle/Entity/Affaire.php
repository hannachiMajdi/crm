<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UsersBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Affaire
 *
 * @ORM\Table(name="affaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AffaireRepository")
 * @UniqueEntity(
 *     fields="ref",
 *     errorPath="ref",
 *     message="La référence existe déja !"
 * )
 */
class Affaire
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
     * @Assert\NotBlank(message="L'etat  ne doit pas étre vide !")
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="affaires")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $contact;

    /**
     *
     * @ORM\OneToOne(targetEntity="Commande", mappedBy="affaire", cascade={"persist", "remove"})
     *
     */
    private $commande;
    /**
     *
     * @ORM\OneToOne(targetEntity="Devis", mappedBy="affaire", cascade={"persist", "remove"})
     *
     */
    private $devis;

    /**
     *
     * @ORM\OneToOne(targetEntity="Facture", mappedBy="affaire", cascade={"persist", "remove"})
     *
     */
    private $facture;

    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\User", inversedBy="affaires")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",nullable=true,onDelete="SET NULL")
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __toString()
    {
        return $this->getRef().' du contact '.(string)$this->contact;
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
     * @return Affaire
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
     * Set etat
     *
     * @param string $etat
     *
     * @return Affaire
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set contact
     *
     * @param \AppBundle\Entity\Contact $contact
     *
     * @return Affaire
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
     * Set commande
     *
     * @param \AppBundle\Entity\Commande $commande
     *
     * @return Affaire
     */
    public function setCommande(\AppBundle\Entity\Commande $commande = null)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \AppBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set devis
     *
     * @param \AppBundle\Entity\Devis $devis
     *
     * @return Affaire
     */
    public function setDevis(\AppBundle\Entity\Devis $devis = null)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis
     *
     * @return \AppBundle\Entity\Devis
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Affaire
     */
    public function setFacture(\AppBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \AppBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set user
     *
     * @param \UsersBundle\Entity\User $user
     *
     * @return Affaire
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
