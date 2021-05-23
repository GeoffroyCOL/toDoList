<?php

namespace App\Listener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class LoginListener implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $manager
    )
    {}

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onLoginSuccess'
        ];
    }
    
    /**
     * onLoginSuccess
     * Ajout la date de dernière connexion d'un utilisateur
     *
     * @param  InteractiveLoginEvent $event
     * @return void
     */
    public function onLoginSuccess(InteractiveLoginEvent $event)
    {
        /** @var User */
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLoginAt(new \DateTime());
        $this->manager->flush();
    }
}