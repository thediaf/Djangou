<?php

/*
 * This file is part of the Djangou application.
 *
 * (c) Diafra Soumaré and Bechir Ba
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

class Search
{
    /**
     * @var string|null
     */
    private $word;

    /**
     * @var Language|null
     */
    private $wordLanguage;

    /**
     * @var Language|null
     */
    private $translateLanguage;

    /**
     * @return string
     */
    public function getWord(): ?string
    {
        return $this->word;
    }

    /**
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
     * @return Language
     */
    public function getWordLanguage(): ?Language
    {
        return $this->wordLanguage;
    }

    /**
     * @return self
     */
    public function setWordLanguage(Language $wordLanguage): ?self
    {
        $this->wordLanguage = $wordLanguage;

        return $this;
    }

    /**
     * @return Language
     */
    public function getTranslateLanguage(): ?Language
    {
        return $this->translateLanguage;
    }

    /**
     * @return self
     */
    public function setTranslateLanguage(Language $translateLanguage): ?self
    {
        $this->translateLanguage = $translateLanguage;

        return $this;
    }
}
