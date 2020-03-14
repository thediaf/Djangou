<?php

namespace App\Event;

use App\Entity\Translate;
use App\Entity\User;
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
