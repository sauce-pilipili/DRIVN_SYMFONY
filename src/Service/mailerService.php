<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class mailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

    }

    public function sendMail(string $from,
                             string $name,
                             string $text)
    {
        $email = (new Email())
            ->from($from)
            ->to('admin@mail.fr')
            ->text('Le client: '.$name.' vous a laissé un message: '.$text);

        $this->mailer->send($email);

    }

    public function sendDemoMail(string $from)
    {
        $email = (new Email())
            ->from($from)
            ->to('admin@mail.fr')
            ->text('Le client souhaite avoir une demo du logiciel ');
        $this->mailer->send($email);

    }


}