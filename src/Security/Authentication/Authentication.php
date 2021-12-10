<?php

namespace App\Security\Authentication;

use App\Entity\Users;
use App\Core\Session\Session;
use App\Entity\AttemptConnection;
use App\Security\Authentication\Exception\AuthenticationException;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class Authentication
{
    public const SESSION_USER_KEY = '__user';

    private int $maxAttempt = 5;

    private Session $session;

    private Request $request;

    public function __construct(Session $session, Request $request)
    {
        $this->session = $session;
        $this->request = $request;
    }

    public function attemptLogin(array $credentials)
    {
        $ip = $this->request->getClientIp();

        $attempt = new AttemptConnection();

        /** @var AttemptConncetion $resultAttempt */
        $resultAttempt = $attempt->findOneBy([
            'params' => [
                'ip' => $ip
            ],
            'extraSQL' => ' AND attempt_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)'
        ]);

        $date = new DateTime();

        if (null === $resultAttempt) {
            $attempt->setIp($ip);
            $attempt->setAttempt(1);
            $attempt->setAttemptAt($date->format('Y-m-d H:i:s'));

            $attempt->save();
        } else {
            if ($attempt >= 5) {
                throw new AuthenticationException('Votre session à été bloquer pour une durée de 15 min');
            } else {
                $resultAttempt->setAttempt($resultAttempt->getAttempt() + 1);
                $resultAttempt->setAttemptAt($date->format('Y-m-d H:i:s'));
                $resultAttempt->save();
            }
        }

        // Contrôle les données de l'utilisateur

        if (null !== ($user = $this->getUser($credentials))) {
            // mise en session de l'utilisateur
            $this->session->set(self::SESSION_USER_KEY, $user);
        }

        throw new AuthenticationException('Votre mot de passe ou email est incorrect, tentative restante : ' . ($this->maxAttempt - $resultAttempt->getAttempt()));
    }

    public function getUser(array $credentials): ?Users
    {
        $user = new Users();

        /** @var Users $user */
        $user = $user->findOneBy([
            'params' => [
                'email' => $credentials['emailInput']
            ]
        ]);

        if (!$user instanceof Users) {
            return null;
        }

        if ($user->getPassword() !== sha1($credentials['passwordInput'])) {
            return null;
        }

        return $user;
    }
}
