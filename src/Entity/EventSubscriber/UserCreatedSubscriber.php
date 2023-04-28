<?php

namespace App\EventSubscriber;

use App\Event\UsersCreatedEvent;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher, private MailerInterface $mailer)
    {}

    public function onUserCreated(UsersCreatedEvent $event): void
    {
        $user = $event->getUser();

        $bytes = openssl_random_pseudo_bytes(9);
        $pass = bin2hex($bytes);

        $email = (new Email())
            ->from('hello@example.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Votre inscription')
            ->text('Votre mot de passe est : ' . $pass)
        ;

        $this->mailer->send($email);

        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $pass
            )
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UsersCreatedEvent::NAME => 'onUserCreated',
        ];
    }
}