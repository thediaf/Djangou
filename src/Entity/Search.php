<?php
namespace App\Entity;


use App\Entity\Language;

class Search
{
    /**
     *
     * @var string|null
     */
    private $word;

    /**
     *
     * @var Language|null
     */
    private $wordLanguage;

    /**
     *
     * @var Language|null
     */
    private $translateLanguage;

    /**
     *
     * @return string
     */
    public function getWord(): ?string
    {
        return $this->word;
    }

    /**
     *
     * @param string $word
     * @return self
     */
    public function setWord(string $word): ?self
    {
        $this->word = $word;

        return $this;
    }

    // /**
    //  *
    //  * @return string
    //  */
    // public function getTranslate(): ?string
    // {
    //     return $this->translate;
    // }

    // /**
    //  *
    //  * @param string $translate
    //  * @return self
    //  */
    // public function setTranslate(string $translate): ?self
    // {
    //     $this->translate = $translate;

    //     return $this;
    // }

    /**
     *
     * @return Language
     */
    public function getWordLanguage(): ?Language
    {
        return $this->wordLanguage;
    }

    /**
     *
     * @param Language $wordLanguage
     * @return self
     */
    public function setWordLanguage(Language $wordLanguage): ?self
    {
        $this->wordLanguage = $wordLanguage;

        return $this;
    }

    /**
     *
     * @return Language
     */
    public function getTranslateLanguage(): ?Language
    {
        return $this->translateLanguage;
    }

    /**
     *
     * @param Language $translateLanguage
     * @return self
     */
    public function setTranslateLanguage(Language $translateLanguage): ?self
    {
        $this->translateLanguage = $translateLanguage;

        return $this;
    }
}