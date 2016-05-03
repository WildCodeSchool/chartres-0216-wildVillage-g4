<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil_user
 *
 * @ORM\Table(name="profil_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Profil_userRepository")
 */
class Profil_user
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
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var bool
     *
     * @ORM\Column(name="bio_ispublic", type="boolean")
     */
    private $bioIspublic;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", nullable=true)
     */
    private $bio;

    /**
     * @var bool
     *
     * @ORM\Column(name="mail_ispublic", type="boolean")
     */
    private $mailIspublic;

    /**
     * @var bool
     *
     * @ORM\Column(name="age_ispublic", type="boolean")
     */
    private $ageIspublic;

    /**
     * @var bool
     *
     * @ORM\Column(name="surname_ispublic", type="boolean")
     */
    private $surnameIspublic;

    /**
     * @var bool
     *
     * @ORM\Column(name="firstname_ispublic", type="boolean")
     */
    private $firstnameIspublic;


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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Profil_user
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set bioIspublic
     *
     * @param boolean $bioIspublic
     *
     * @return Profil_user
     */
    public function setBioIspublic($bioIspublic)
    {
        $this->bioIspublic = $bioIspublic;

        return $this;
    }

    /**
     * Get bioIspublic
     *
     * @return bool
     */
    public function getBioIspublic()
    {
        return $this->bioIspublic;
    }

    /**
     * Set bio
     *
     * @param string $bio
     *
     * @return Profil_user
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set mailIspublic
     *
     * @param boolean $mailIspublic
     *
     * @return Profil_user
     */
    public function setMailIspublic($mailIspublic)
    {
        $this->mailIspublic = $mailIspublic;

        return $this;
    }

    /**
     * Get mailIspublic
     *
     * @return bool
     */
    public function getMailIspublic()
    {
        return $this->mailIspublic;
    }

    /**
     * Set ageIspublic
     *
     * @param boolean $ageIspublic
     *
     * @return Profil_user
     */
    public function setAgeIspublic($ageIspublic)
    {
        $this->ageIspublic = $ageIspublic;

        return $this;
    }

    /**
     * Get ageIspublic
     *
     * @return bool
     */
    public function getAgeIspublic()
    {
        return $this->ageIspublic;
    }

    /**
     * Set surnameIspublic
     *
     * @param boolean $surnameIspublic
     *
     * @return Profil_user
     */
    public function setSurnameIspublic($surnameIspublic)
    {
        $this->surnameIspublic = $surnameIspublic;

        return $this;
    }

    /**
     * Get surnameIspublic
     *
     * @return bool
     */
    public function getSurnameIspublic()
    {
        return $this->surnameIspublic;
    }

    /**
     * Set firstnameIspublic
     *
     * @param boolean $firstnameIspublic
     *
     * @return Profil_user
     */
    public function setFirstnameIspublic($firstnameIspublic)
    {
        $this->firstnameIspublic = $firstnameIspublic;

        return $this;
    }

    /**
     * Get firstnameIspublic
     *
     * @return bool
     */
    public function getFirstnameIspublic()
    {
        return $this->firstnameIspublic;
    }
}

