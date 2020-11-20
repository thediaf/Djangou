<?php

/*
 * This file is part of the Djangou application.
 *
 * (c) Diafra Soumaré and Bechir Ba
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Event;

use App\Entity\Translate;
use Symfony\Contracts\EventDispatcher\Event;

class TranslateEvent extends Event
{
    private $source;
    private $target;

    public function __construct(Translate $source, Translate $target)
    {
        $this->source = $source;
        $this->target = $target;
    }

    public function getSource(): Translate
    {
        return $this->source;
    }

    public function getTarget(): Translate
    {
        return $this->target;
    }
}
