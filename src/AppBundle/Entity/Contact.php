<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 * @UniqueEntity(
 *     fields="email",
 *     errorPath="email",
 *     message="L'email existe déja !"
 * )
 */
class Contact
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
     * @var string
     * @Assert\NotBlank(message="La fonction ne doit pas étre vide !")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Mininmum 2 caractéres pour La fonction"
     * )
     * @ORM\Column(name="fonction", type="string", length=255)
     */
    private $fonction;

    /**
     * @var string
     * @Assert\NotBlank(message="Le N° de tel ne doit pas étre vide !")
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Mininmum 8 caractéres pour N° de tel"
     * )
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Seulement des chiffres")
     * @ORM\Column(name="tel", type="string",length=30)
     */
    private $tel;

    /**
     * @var string
     * @Assert\NotBlank(message="L'email ne doit pas étre vide !")
     * @Assert\Email(message="Email n'est pas valide")
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     *
     * @ORM\OneToOne(targetEntity="UsersBundle\Entity\User", inversedBy="contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;
    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation", inversedBy="contacts")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id",nullable=true)
     */
    private $organisation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Campagne", inversedBy="contacts")
     * @ORM\JoinColumn(name="campagne_id", referencedColumnName="id",nullable=true,onDelete="SET NULL")
     */
    private $campagne;

    /**
     *
     * @ORM\OneToMany(targetEntity="Affaire", mappedBy="contact", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $affaires;
    /**
     *
     * @ORM\OneToMany(targetEntity="TicketClient", mappedBy="contact", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $ticketClients;

    public function __construct() {
        $this->affaires = new ArrayCollection();
        $this->ticketClients = new ArrayCollection();
    }

    public  function __toString()
    {
        return $this->id.' '.$this->nom;
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
     * @return Contact
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
     * Set fonction
     *
     * @param string $fonction
     *
     * @return Contact
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Contact
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set organisation
     *
     * @param \AppBundle\Entity\Organisation $organisation
     *
     * @return Contact
     */
    public function setOrganisation(\AppBundle\Entity\Organisation $organisation = null)
    {
        $this->organisation = $organisation;

        return $this;
    }

    /**
     * Get organisation
     *
     * @return \AppBundle\Entity\Organisation
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Set campagne
     *
     * @param \AppBundle\Entity\Campagne $campagne
     *
     * @return Contact
     */
    public function setCampagne(\AppBundle\Entity\Campagne $campagne = null)
    {
        $this->campagne = $campagne;

        return $this;
    }

    /**
     * Get campagne
     *
     * @return \AppBundle\Entity\Campagne
     */
    public function getCampagne()
    {
        return $this->campagne;
    }

    /**
     * Set user
     *
     * @param \UsersBundle\Entity\User $user
     *
     * @return Contact
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
     * Add affaire
     *
     * @param \AppBundle\Entity\Affaire $affaire
     *
     * @return Contact
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
     * Add ticketClient
     *
     * @param \AppBundle\Entity\TicketClient $ticketClient
     *
     * @return Contact
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
}
