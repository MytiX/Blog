<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Mailer\Mailer;
use App\Core\Route\Route;
use App\Core\Templating\Templating;
use App\Entity\Posts;
use App\Security\Form\ContactFormSecurity;
use Config\AppConfig;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function home()
    {
        $posts = new Posts();

        $session = $this->getSession();

        $resultPosts = $posts->findBy([
            'params' => [
                'active' => 1,
            ],
            'orderBy' => [
                'created_at DESC',
            ],
            'limit' => 10,
        ]);

        $postsPromote = $posts->findBy([
            'params' => [
                'active' => 1,
                'promote' => 1,
            ],
        ]);

        $form = new ContactFormSecurity($this->getRequest(), $session);

        if ($form->isSubmit() && $form->isValid()) {
            $data = $form->getData();

            $templating = new Templating();

            $message = $templating->getView('/emails/contactForm.php', [
                'email' => $data['emailInput'],
                'objet' => $data['objetInput'],
                'message' => nl2br(htmlspecialchars($data['messageInput'])),
                'name' => sprintf('%s %s', $data['firstname'], $data['lastname']),
            ]);

            $mailer = new Mailer();

            $mailer->sendMail('Un utilisateur de DevCoding vous a envoyé un message', AppConfig::CONTACT_FORM_EMAIL, $message, ['Reply-To' => $data['emailInput']]);

            $session->set('successFlash', 'Votre email à bien été envoyé, nous répondrons dans les plus brefs délai.');

            $form->clearData();
        }

        return $this->render('/home/home.php', [
            'posts' => $resultPosts,
            'postsPromote' => $postsPromote,
            'form' => $form->getData(),
        ]);
    }
}
