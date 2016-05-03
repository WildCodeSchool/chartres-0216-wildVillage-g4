<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LinkRepository")
 */
class Link
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
     * @ORM\Column(name="id_profil", type="integer")
     */
    private $idProfil;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var bool
     *
     * @ORM\Column(name="ispublic", type="boolean")
     */
    private $ispublic;

    /**
     * @var string
     *
     * @ORM\Column(name="label_link", type="string", length=255)
     */
    private $labelLink;


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
     * Set idProfil
     *
     * @param integer $idProfil
     *
     * @return Link
     */
    public function setIdProfil($idProfil)
    {
        $this->idProfil = $idProfil;

        return $this;
    }

    /**
     * Get idProfil
     *
     * @return int
     */
    public function getIdProfil()
    {
        return $this->idProfil;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set ispublic
     *
     * @param boolean $ispublic
     *
     * @return Link
     */
    public function setIspublic($ispublic)
    {
        $this->ispublic = $ispublic;

        return $this;
    }

    /**
     * Get ispublic
     *
     * @return bool
     */
    public function getIspublic()
    {
        return $this->ispublic;
    }

    /**
     * Set labelLink
     *
     * @param string $labelLink
     *
     * @return Link
     */
    public function setLabelLink($labelLink)
    {
        $this->labelLink = $labelLink;

        return $this;
    }

    /**
     * Get labelLink
     *
     * @return string
     */
    public function getLabelLink()
    {
        return $this->labelLink;
    }
}

