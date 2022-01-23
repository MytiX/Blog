<?php

namespace App\Controller;

use DateTime;
use App\Entity\Users;
use Config\AppConfig;
use App\Core\Route\Route;
use App\Core\Mailer\Mailer;
use App\Core\Templating\Templating;
use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Security\Form\EmailResetPasswordFormSecurity;
use App\Security\Form\NewPasswordFormSecurity;
use DateInterval;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password')]
    public function resetPassword(): Response
    {
        $session = $this->getSession();

        $form = new EmailResetPasswordFormSecurity($this->getRequest(), $session);

        if ($form->isSubmit() && $form->isValid()) {
            $data = $form->getData();

            /** @var Users $user */
            $user = (new Users())->findOneBy([
                'params' => [
                    'email' => $data['emailInput'],
                ],
            ]);

            if (null !== $user) {
                $code = sha1($user->getEmail());

                $user->setResetPassCode($code);
                $user->setResetPassCreatedAt(((new DateTime())->add(DateInterval::createFromDateString('1 hours'))->format('Y-m-d H:i:s')));
                $user->save();

                $templating = new Templating();

                $message = $templating->getView('/emails/resetPassword.php', [
                    'email' => $user->getEmail(),
                    'code' => $user->getResetPassCode(),
                ]);

                $mailer = new Mailer();

                $mailer->sendMail('Demande de réinitialisation mot de passe', $user->getEmail(), $message);

                $session->set('successFlash', 'Un email vous a été envoyer afin de réinitialiser votre mot de passe.');

                // $form->clearData(); TODO function exist on branch Feature_Contact after rebase uncomment this part
            } else {
                $session->set('errorFlash', 'Le compte n\'existe pas ou l\'email est incorrect.');
            }
        }

        return $this->render('/reset-password/emailResetPassword.php', [
            'form' => $form->getData(),
        ]);
    }

    #[Route('/new-password')]
    public function newPassword(): Response
    {
        $request = $this->getRequest();
        $session = $this->getSession();

        $email = $request->query->get('email');
        $code = $request->query->get('code');

        if (empty($email) || empty($code) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $session->set('errorFlash', 'Une erreur est survenue lors de la procédure réinitialisation de votre mot de passe, veuillez refaire la demande de réinitialisation.');
            return new RedirectResponse(AppConfig::URL.'/reset-password');
        }

        /** @var Users $user */
        $user = (new Users())->findOneBy([
            'params' => [
                'email' => $email,
            ],
        ]);

        if (null === $user) {
            $session->set('errorFlash', 'Une erreur est survenue lors de la procédure réinitialisation de votre mot de passe, veuillez refaire la demande de réinitialisation.');
            return new RedirectResponse(AppConfig::URL.'/reset-password');
        }

        $now = new DateTime();

        if ($user->getResetPassCreatedAt() < $now || $code !== $user->getResetPassCode()) {
            $session->set('errorFlash', 'Votre code n\'est plus valide, veuillez refaire la demande de réinitialisation.');
            return new RedirectResponse(AppConfig::URL.'/reset-password');
        }

        $form = new NewPasswordFormSecurity($request, $session);

        if ($form->isSubmit() && $form->isValid()) {
            $data = $form->getData();
            if ($data['passwordInput'] === $data['cPasswordInput']) {
                $user->setPassword(sha1($data['passwordInput']));
                $user->save();
                $session->set('successFlash', 'Votre mot de passe à bien été réinitialisé.');
                return new RedirectResponse(AppConfig::URL.'/signin');

            }
            $session->set('errorFlash', 'Vous avez saisi 2 mots de passe différents, veuillez saisir le même mot de passe dans les 2 champs.');
        }

        return $this->render('/reset-password/newPassword.php');
    }
}
