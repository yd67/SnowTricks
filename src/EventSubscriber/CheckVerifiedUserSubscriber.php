<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', '-10']
        ];
    }

    public function onCheckPassport(CheckPassportEvent $event)
    {
        $passport = $event->getPassport();
        $user = $passport->getUser();

        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }

        if (!$user->isIsVerified()) {
            throw new CustomUserMessageAuthenticationException(
                'Vous devez valider votre Compte afin de vous connecter . 
                Un email de comfirmation vous a été envoyé au moment de votre inscription '
            );
        }
    }
}
