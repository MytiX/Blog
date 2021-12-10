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

    private int $timeout = 900;

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

        /** @var AttemptConncetion $attempt */
        $attempt = (new AttemptConnection())->findOneBy([
            'params' => [
                'ip' => $ip
            ],
        ]);

        $now = new DateTime();

        if (null === $attempt) {
            $attempt = new AttemptConnection();
            $attempt->setIp($ip);
            $attempt->setAttemptAt($now->format('Y-m-d H:i:s'));
        }

        if ($now->getTimestamp() - $attempt->getAttemptAt()->getTimestamp() > $this->timeout) {
            $attempt->setAttempt(0);
        }

        if ($attempt->getAttempt() >= $this->maxAttempt && $now->getTimestamp() - $attempt->getAttemptAt()->getTimestamp() < $this->timeout) {
            $timeoutInterval = (new DateTime())->setTimestamp($attempt->getAttemptAt()->getTimestamp() + $this->timeout);
            throw new AuthenticationException('Votre session à été bloquer pour une durée de 15 min. </br> Temps restant : ' . $now->diff($timeoutInterval)->format('%i min %s sec'));
        }

        // Contrôle les données de l'utilisateur

        if (null === ($user = $this->getUser($credentials))) {
            $attempt->setAttempt($attempt->getAttempt() + 1);
            $attempt->setAttemptAt($now->format('Y-m-d H:i:s'));
            $attempt->save();
            throw new AuthenticationException('Votre mot de passe ou email est incorrect, tentative restante : ' . ($this->maxAttempt - $attempt->getAttempt()));
        }

        $attempt->delete($attempt->getId());

        // mise en session de l'utilisateur
        $this->session->set(self::SESSION_USER_KEY, $user);
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
