<?php

namespace App\EventSubscriber;

use App\Entity\History;
use App\Entity\User;
use App\Event\TranslateEvent;
use App\Event\TranslateEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TranslateSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    private $user;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function onTranslateRequested(TranslateEvent $event)
    {
        if($this->user instanceof User) {
            $history = (new History())
                ->setSource($event->getSource())
                ->setTarget($event->getTarget())
                ->setUser($this->user);
            $this->user->addHistory($history);
            $this->entityManager->persist($history);
            $this->entityManager->flush();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            TranslateEvents::TRANSLATE_REQUESTED => 'onTranslateRequested',
        ];
    }
}
