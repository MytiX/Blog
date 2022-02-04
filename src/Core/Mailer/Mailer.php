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

    /**
     * sendMail
     * 
     * @param  string $subject
     * @param  string|array $to
     * @param  string $message
     * @param  array $additionnalHeader
     * @return int
     */
    public function sendMail(string $subject, string|array $to, string $message, array $additionnalHeader = []): int
    {
        if (false === is_array($to)) {
            $to = [$to];
        }

        $header = array_merge(['Reply-To' => $to[0]], $additionnalHeader);

        $message = (new \Swift_Message($subject))
        ->setFrom(MailerConfig::FROM_MAILER)
        ->setTo($to)
        ->setBody($message, 'text/html');

        foreach ($header as $key => $value) {
            $message->getHeaders()->addTextHeader($key, $value);
        }

        return $this->mailer->send($message);
    }
}
