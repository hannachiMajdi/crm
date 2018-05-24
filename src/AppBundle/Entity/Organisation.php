<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Organisation
 *
 * @ORM\Table(name="organisation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganisationRepository")
 * @UniqueEntity(
 *     fields="email",
 *     errorPath="email",
 *     message="L'email existe déja !"
 * )
 *
 */
class Organisation
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

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
     * @var string
     * @Assert\Url(message="url du siteweb non valide")
     * @ORM\Column(name="siteweb", type="string", length=255, nullable=true)
     */
    private $siteweb;

    /**
     * @var string
     * @Assert\NotBlank(message="Le Secteur de tel ne doit pas étre vide !")
     * @ORM\Column(name="secteur", type="string", length=255)
     */
    private $secteur;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Contact", mappedBy="organisation", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $contacts;
    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Prospect", mappedBy="organisation", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $prospects;

    /**
     * Organisation constructor.
     */
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->prospects = new ArrayCollection();
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
     * @return Organisation
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
     * Set tel
     *
     * @param string $tel
     *
     * @return Organisation
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
     * @return Organisation
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
     * Set siteweb
     *
     * @param string $siteweb
     *
     * @return Organisation
     */
    public function setSiteweb($siteweb)
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    /**
     * Get siteweb
     *
     * @return string
     */
    public function getSiteweb()
    {
        return $this->siteweb;
    }

    /**
     * Set secteur
     *
     * @param string $secteur
     *
     * @return Organisation
     */
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return string
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
