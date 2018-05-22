<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoMailing
 *
 * @ORM\Table(name="info_mailing")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoMailingRepository")
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
     *
     * @ORM\Column(name="email_principale", type="string", length=255)
     */
    private $emailPrincipale;

    /**
     * @var string
     *
     * @ORM\Column(name="email_secondaire", type="string", length=255)
     */
    private $emailSecondaire;

    /**
     *
     * @ORM\OneToOne(targetEntity="UsersBundle\Entity\User", inversedBy="mailing")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
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
