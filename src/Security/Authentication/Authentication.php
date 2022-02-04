<?php

namespace App\Security\Authentication;

use App\Core\Mailer\Mailer;
use App\Core\Session\Session;
use App\Core\Templating\Templating;
use App\Entity\AttemptConnection;
use App\Entity\Users;
use Config\AppConfig;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class Authentication
{
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
                'ip' => $ip,
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
            $this->session->set('errorFlash', 'Votre session à été bloquer pour une durée de 15 min. </br> Temps restant : '.$now->diff($timeoutInterval)->format('%i min %s sec'));

            return false;
        }

        if (null === ($user = $this->getUser($credentials))) {
            $attempt->setAttempt($attempt->getAttempt() + 1);
            $attempt->setAttemptAt($now->format('Y-m-d H:i:s'));
            $attempt->save();
            $this->session->set('errorFlash', 'Votre mot de passe ou email est incorrect, tentative restante : '.($this->maxAttempt - $attempt->getAttempt()));

            return false;
        }

        if (0 === $user->getActive()) {
            $templating = new Templating();

            $message = $templating->getView('/emails/signup.php', [
                'email' => $user->getEmail(),
                'code' => $user->getCodeAuth(),
            ]);

            $mailer = new Mailer();

            $mailer->sendMail('Confirmer votre compte DevCoding', $user->getEmail(), $message);

            $this->session->set('errorFlash', 'Vous n\'avez pas encore activé votre compte, nous venons de vous renvoyer un email.');

            return false;
        }

        $attempt->delete($attempt->getId());

        $this->session->set(AppConfig::USER_SESSION, [
            'id' => $user->getId(),
            'pseudo' => $user->getPseudo(),
            'email' => $user->getEmail(),
            'role' => $user->getRole(),
        ]);

        return true;
    }

    public function getUser(array $credentials): ?Users
    {
        $user = new Users();

        /** @var Users $user */
        $user = $user->findOneBy([
            'params' => [
                'email' => $credentials['emailInput'],
            ],
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
