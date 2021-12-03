<?php

namespace App\Controller;

use DateTime;
use App\Entity\Users;
use App\Core\Route\Route;
use App\Core\Mailer\Mailer;
use App\Core\Templating\Templating;
use App\Security\Form\SignUpFormSecurity;
use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SignController extends AbstractController
{
    #[Route('/signup', false)]
    public function signUp(): Response
    {
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

                        $templating = new Templating();

                        $message = $templating->getView('/emails/signup.php', [
                            'email' => $user->getEmail(),
                            'code' => $user->getCodeAuth(),
                        ]);

                        try {
                            $mailer = new Mailer();

                            $mailer->sendMail('Confirmer votre compte DevCoding', $user->getEmail(), $message);

                            $form->setMessages('globalSuccess', 'Votre compte à bien été crée, veuillez confirmer votre adresse mail');

                        } catch (\Throwable $th) {
                            // Supprime l'utilisateur
                            // Message d'erreur
                            // $form->setMessages('globalError', 'Votre compte à bien été crée, veuillez confirmer votre adresse mail');
                        }


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
        $session = $this->getSession();

        // $session->set('__user', $user);


        return $this->render('/sign/signIn.php');
    }
}
