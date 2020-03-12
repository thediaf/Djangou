<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TranslateRepository")
 */
class Translate implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Translate", inversedBy="translates")
     */
    private $words;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Translate", mappedBy="words")
     */
    private $translates;

    public function __construct()
    {
        $this->words = new ArrayCollection();
        $this->translates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    public function addWords(Translate $word): self
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
        }

        return $this;
    }

    public function removeWords(Translate $words): self
    {
        if ($this->words->contains($words)) {
            $this->words->removeElement($words);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTranslates(): Collection
    {
        return $this->translates;
    }

    public function addTranslate(self $translate): self
    {
        if (!$this->translates->contains($translate)) {
            $this->translates[] = $translate;
            $translate->addWords($this);
        }

        return $this;
    }

    public function removeTranslate(self $translate): self
    {
        if ($this->translates->contains($translate)) {
            $this->translates->removeElement($translate);
            $translate->removeWords($this);
        }

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'classe' => $this->classe,
            'word' => $this->word
        ];
    }
}
