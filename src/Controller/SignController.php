<?php

namespace App\Controller;

use App\Core\Route\Route;
use App\Core\Controller\AbstractController;
use App\Entity\Users;
use App\Security\SignUpFormSecurity;
use Config\SwiftMailerConfig;
use DateTime;

class SignController extends AbstractController
{
    #[Route('/signup', false)]
    public function signUp()
    {
        $transport = (new \Swift_SmtpTransport(SwiftMailerConfig::HOST_MAILER));

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Confirmer votre compte DevCoding'))
        ->setFrom(SwiftMailerConfig::FROM_MAILER)
        ->setTo(['test@test.fr'])
        ->setBody("<div style='text-align: center'>
        <p>Veulliez valider votre compte DevCoding en cliquant sur le lien si dessous :</p>
        <a href='http://localhost:8741/validate-account?email=test@test.fr&code=test'>Cliquez ici</a>
        </div>", 'text/html');

        $result = $mailer->send($message);

        dd($result);

        $form = new SignUpFormSecurity($this->getRequest());

        if ($form->isSubmit() && $form->isValid()) {

            $formData = $form->getData();

            if ($formData['passwordInput'] == $formData['cPasswordInput']) {

                $user = new Users();

                $userFind = $user->findOneBy([
                    'params' => [
                        'email' => $formData['emailInput']
                    ]
                ]);

                if ($userFind) {
                    $form->setMessages('globalError', 'Cette adresse mail existe déjà.');
                } else {
                    $date = new DateTime();

                    $user->setEmail($formData['emailInput']);
                    $user->setPassword(sha1($formData['passwordInput']));
                    $user->setPseudo($formData['pseudoInput']);
                    $user->setCreatedAt($date->format('Y-m-d H:i:s'));
                    $user->setCodeAuth(sha1($formData['emailInput'] . $formData['passwordInput']));

                    $user->save();

                    if (!empty($user->getId())) {
                        $form->setMessages('globalSuccess', 'Votre compte à bien été crée, veuillez confirmer votre adresse mail');
                    } else {
                        $form->setMessages('globalError', 'Une erreur est survenu, veuillez réessayer ultérieurement.');
                    }
                }
            } else {
                $form->setMessages('passwordInput', 'Le mot de passe doit être identique.');
            }
        }

        return $this->render('/sign/signUp.php', [
            'formErrors' => $form->getMessages(),
            'formValue' => $form->getData(),
        ]);
    }

    #[Route('/signin')]
    public function signIn()
    {
        return $this->render('/sign/signIn.php');
    }
}
