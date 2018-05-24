<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UsersBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Campagne
 *
 * @ORM\Table(name="campagne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CampagneRepository")
 */
class Campagne
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
     * @Assert\NotBlank(message="Le nom ne doit pas étre vide !")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Mininmum 2 caractéres pour Le nom"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="le nom ne peut pas contenir un nombre"
     * )
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="La date ne doit pas étre vide !")
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     * @Assert\NotBlank(message="L'etat  ne doit pas étre vide !")
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Prospect", mappedBy="campagne", cascade={"persist"} )
     */
    private $prospects;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Contact", mappedBy="campagne", cascade={"persist"} )
     */
    private $contacts;


    /**
     *
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\User", inversedBy="ticketClients")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",nullable=true , onDelete="SET NULL")
     */
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
        $this->prospects = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Campagne
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
     *
     * @return Campagne
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
     * Set description
     *
     * @param string $description
     *
     * @return Campagne
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
     * Add prospect
     *
     * @param \AppBundle\Entity\Prospect $prospect
     *
     * @return Campagne
     */
    public function addProspect(\AppBundle\Entity\Prospect $prospect)
    {
        $prospect->setCampagne($this);
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

    /**
     * Set user
     *
     * @param \UsersBundle\Entity\User $user
     *
     * @return Campagne
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
     * Add contact
     *
     * @param \AppBundle\Entity\Contact $contact
     *
     * @return Campagne
     */
    public function addContact(\AppBundle\Entity\Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \AppBundle\Entity\Contact $contact
     */
    public function removeContact(\AppBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
