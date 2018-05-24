<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * InfoMailing
 *
 * @ORM\Table(name="info_mailing")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoMailingRepository")
 * @UniqueEntity(
 *     fields="emailPrincipale",
 *     errorPath="emailPrincipale",
 *     message="L'email existe déja !"
 * )
 */
class InfoMailing
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
     * @Assert\NotBlank(message="L'email ne doit pas étre vide !")
     * @Assert\Email(message="Email n'est pas valide")
     * @ORM\Column(name="email_principale", type="string", length=255,unique=true)
     */
    private $emailPrincipale;

    /**
     * @var string
     * @Assert\Email(message="Email n'est pas valide")
     * @ORM\Column(name="email_secondaire", type="string", length=255,nullable=true)
     */
    private $emailSecondaire;

    /**
     *
     * @ORM\OneToOne(targetEntity="UsersBundle\Entity\User", inversedBy="mailing", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $user;


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
     * Set emailPrincipale
     *
     * @param string $emailPrincipale
     *
     * @return InfoMailing
     */
    public function setEmailPrincipale($emailPrincipale)
    {
        $this->emailPrincipale = $emailPrincipale;

        return $this;
    }

    /**
     * Get emailPrincipale
     *
     * @return string
     */
    public function getEmailPrincipale()
    {
        return $this->emailPrincipale;
    }

    /**
     * Set emailSecondaire
     *
     * @param string $emailSecondaire
     *
     * @return InfoMailing
     */
    public function setEmailSecondaire($emailSecondaire)
    {
        $this->emailSecondaire = $emailSecondaire;

        return $this;
    }

    /**
     * Get emailSecondaire
     *
     * @return string
     */
    public function getEmailSecondaire()
    {
        return $this->emailSecondaire;
    }

    /**
     * Set user
     *
     * @param \UsersBundle\Entity\User $user
     *
     * @return InfoMailing
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
