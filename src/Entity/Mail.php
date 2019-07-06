<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MailRepository")
 */
class Mail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="mails")
     */
    private $exp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recipient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * Mail constructor.
     */
    public function __construct()
    {
        $this->exp = new ArrayCollection();
        $this->date = new \DateTime("now");

    }

    /***************** ******************/
    /*************  GETTER  *************/
    /***************** ******************/

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getExp(): Collection
    {
        return $this->exp;
    }

    /**
     * @return string|null
     */
    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    /***************** ******************/
    /*************  SETTER  *************/
    /***************** ******************/

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @param string $subject
     * @return Mail
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param string|null $content
     * @return Mail
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string|null $attachment
     * @return Mail
     */
    public function setAttachment(?string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Mail
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param User $exp
     * @return Mail
     */
    public function addExp(User $exp): self
    {
        if (!$this->exp->contains($exp)) {
            $this->exp[] = $exp;
        }

        return $this;
    }

    /**
     * @param User $exp
     * @return Mail
     */
    public function removeExp(User $exp): self
    {
        if ($this->exp->contains($exp)) {
            $this->exp->removeElement($exp);
        }

        return $this;
    }
}
