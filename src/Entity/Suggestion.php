<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SuggestionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Suggestion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="suggestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $suggestedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $acceptedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Translate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $translate;

    const PENDING = 'pending';
    const ACCTEPED = 'accepted';
    const REJECTED = 'rejected';

    const STATUS = [self::PENDING, self::ACCTEPED, self::REJECTED];


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSuggestedAt(): ?\DateTimeInterface
    {
        return $this->suggestedAt;
    }

    public function setSuggestedAt(\DateTimeInterface $suggestedAt): self
    {
        $this->suggestedAt = $suggestedAt;

        return $this;
    }

    public function getAcceptedAt(): ?\DateTimeInterface
    {
        return $this->acceptedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setAcceptedAt(): self
    {
        $this->acceptedAt = new \DateTime();

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if(!in_array($status, self::STATUS)) {
            throw new \InvalidArgumentException(sprintf("status must be on of (%s), %s given", implode(", ", self::STATUS)));
        }

        $this->status = $status;

        if($status == self::ACCTEPED) {
            $this->acceptedAt = new \DateTime();
        }

        return $this;
    }

    public function getTranslate(): ?Translate
    {
        return $this->translate;
    }

    public function setTranslate(?Translate $translate): self
    {
        $this->translate = $translate;

        return $this;
    }

    public function getWord(): ?string
    {
        return $this->translate ? $this->translate->getWord() : null;
    }

    public function getLanguage(): ?Language
    {
        return $this->translate ? $this->translate->getLanguage() : null;
    }

    public function getBadgeStatus(): string
    {
        switch($this->status) {
            case self::PENDING:
                return 'warning';
            case self::REJECTED:
                return 'danger';
            case self::ACCTEPED:
                return 'success';
            default:
                return 'default';
        }
    }
}
