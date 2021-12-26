<?php

namespace App\Core\Mailer;

use Config\MailerConfig;

class Mailer
{
    private \Swift_Mailer $mailer;

    public function __construct()
    {
        $this->mailer = new \Swift_Mailer(new \Swift_SmtpTransport(MailerConfig::HOST_MAILER, MailerConfig::PORT_MAILER));
    }

    public function sendMail(string $subject, string|array $to, string $message): bool
    {
        $message = (new \Swift_Message($subject))
        ->setFrom(MailerConfig::FROM_MAILER)
        ->setTo($to)
        ->setBody($message, 'text/html');

        return $this->mailer->send($message);
    }
}
