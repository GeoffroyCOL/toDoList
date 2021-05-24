<?php

namespace App\Listener;

use App\Entity\User;
use App\Service\EmailService;
use Symfony\Component\HttpFoundation\Session\Session;

class UserListener
{
    private $session;

    public function __construct(private EmailService $emailService)
    {
        $this->session = new Session();
    }
    
    /**
     * postPersist
     * Envoie d'un email après l'inscription d'un utilisateur
     *
     * @return void
     */
    public function postPersist($args): void
    {
        $this->emailService->register($args);
    }

    /**
     * prePersist
     * Quand un utilisateur supprime son profil
     * 
     * @return void
     */
    public function postRemove()
    {
        $this->session->invalidate();
    }
}