<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Mailer\Mailer;
use App\Core\Route\Route;
use App\Core\Templating\Templating;
use App\Entity\Users;
use App\Security\Authentication\Authentication;
use App\Security\Form\SignInFormSecurity;
use App\Security\Form\SignUpFormSecurity;
use Config\AppConfig;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SignController extends AbstractController
{
    #[Route('/signup', false)]
    public function signUp(): Response
    {
        $session = $this->getSession();
        $form = new SignUpFormSecurity($this->getRequest(), $session);

        if ($form->isSubmit() && $form->isValid()) {
            $formData = $form->getData();

            if ($formData['passwordInput'] == $formData['cPasswordInput']) {
                $user = new Users();

                $userFind = $user->findOneBy([
                    'params' => [
                        'email' => $formData['emailInput'],
                    ],
                ]);

                if ($userFind) {
                    $session->set('globalError', 'Cette adresse mail existe déjà.');
                } else {
                    $date = new DateTime();

                    $user->setEmail($formData['emailInput']);
                    $user->setPassword(sha1($formData['passwordInput']));
                    $user->setPseudo($formData['pseudoInput']);
                    $user->setCreatedAt($date->format('Y-m-d H:i:s'));
                    $user->setCodeAuth(sha1($formData['emailInput'].$formData['passwordInput']));

                    $user->save();

                    if (!empty($user->getId())) {
                        $templating = new Templating();

                        $message = $templating->getView('/emails/signup.php', [
                            'email' => $user->getEmail(),
                            'code' => $user->getCodeAuth(),
                        ]);

                        $mailer = new Mailer();

                        $mailer->sendMail('Confirmer votre compte DevCoding', $user->getEmail(), $message);

                        $session->set('globalSuccess', 'Votre compte à bien été crée, veuillez confirmer votre adresse mail.');

                        return new RedirectResponse(AppConfig::URL.'/signin');

                    } else {
                        $session->set('globalError', 'Une erreur est survenu, veuillez réessayer ultérieurement.');
                    }
                }
            } else {
                $session->set('passwordInput', 'Le mot de passe doit être identique.');
            }
        }

        return $this->render('/sign/signUp.php', [
            'formValue' => $form->getData(),
        ]);
    }

    #[Route('/signin')]
    public function signIn(): Response
    {
        $session = $this->getSession();

        $form = new SignInFormSecurity($this->getRequest(), $this->getSession());

        if ($form->isSubmit() && $form->isValid()) {
            $credientials = $form->getData();

            $auth = new Authentication($session, $this->getRequest());

            if ($auth->attemptLogin($credientials)) {
                return new RedirectResponse(AppConfig::URL);
            }
        }

        return $this->render('/sign/signIn.php');
    }

    #[Route('/logout')]
    public function logOut(): RedirectResponse
    {
        $session = $this->getSession();

        $session->remove('__user');

        return new RedirectResponse(AppConfig::URL);
    }
}
