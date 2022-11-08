<?php

namespace App\Services ;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class Mailer 
{
    public function __construct(MailerInterface $mailer )
    {
        $this->mailer = $mailer ;
    }

    public function sendResetPass($email,$url)
    {
        $email = (new TemplatedEmail())
        ->from('snowtriks@gmail.com')
        ->to($email)
        ->subject('Réinitilisation mot de passe')
        ->htmlTemplate('mail/resetPassword.html.twig')
        ->context([
            'url' => $url
        ]);
        $this->mailer->send($email);
    }

    public function sendVerifEmail($email,$url)
    {
        $email = (new TemplatedEmail())
        ->from('snowtriks@gmail.com')
        ->to($email)
        ->subject('Réinitilisation mot de passe')
        ->htmlTemplate('mail/verifEmail.html.twig')
        ->context([
            'url' => $url
        ]);
        $this->mailer->send($email);

    }
}