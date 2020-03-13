<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Translate")
     */
    private $translations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    const PENDING = 'pending';
    const ACCTEPED = 'accepted';
    const REJECTED = 'rejected';

    const STATUS = [self::PENDING, self::ACCTEPED, self::REJECTED];

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

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

    /**
     * @return Collection|Translate[]
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(Translate $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
        }

        return $this;
    }

    public function removeTranslation(Translate $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }

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

}
