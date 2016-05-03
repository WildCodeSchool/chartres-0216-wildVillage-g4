<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="id_send", type="integer")
     */
    private $idSend;

    /**
     * @var int
     *
     * @ORM\Column(name="id_receive", type="integer")
     */
    private $idReceive;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set idSend
     *
     * @param integer $idSend
     *
     * @return Message
     */
    public function setIdSend($idSend)
    {
        $this->idSend = $idSend;

        return $this;
    }

    /**
     * Get idSend
     *
     * @return int
     */
    public function getIdSend()
    {
        return $this->idSend;
    }

    /**
     * Set idReceive
     *
     * @param integer $idReceive
     *
     * @return Message
     */
    public function setIdReceive($idReceive)
    {
        $this->idReceive = $idReceive;

        return $this;
    }

    /**
     * Get idReceive
     *
     * @return int
     */
    public function getIdReceive()
    {
        return $this->idReceive;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Message
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
}

