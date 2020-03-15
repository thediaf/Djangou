<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoryRepository")
 * @ORM\HaslifeCycleCallbacks()
 */
class History
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="histories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Translate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Translate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $target;

    /**
     * @ORM\Column(type="datetime")
     */
    private $searchedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMemorised = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSource(): Translate
    {
        return $this->source;
    }

    public function setSource(Translate $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getTarget(): Translate
    {
        return $this->target;
    }

    public function setTarget(Translate $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getSearchedAt(): ?\DateTimeInterface
    {
        return $this->searchedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setSearchedAt(): self
    {
        $this->searchedAt = new \DateTime();

        return $this;
    }

    public function getIsMemorised(): bool
    {
        return $this->isMemorised;
    }

    public function setIsMemorised(bool $isMemorised): self
    {
        $this->isMemorised = $isMemorised;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function equals(History $history): bool
    {
        return $this->source == $history->getSource()
            && $this->target == $history->getTarget()
            && $this->user   == $history->getUser()
        ;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateToken(): self
    {
        $this->token = md5(time());

        return $this;
    }
}
