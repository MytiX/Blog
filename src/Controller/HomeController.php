<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Core\Route\Route;
use App\Core\Mailer\Mailer;
use App\Core\Templating\Templating;
use App\Security\Form\ContactFormSecurity;
use App\Core\Controller\AbstractController;
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
                'message' => $data['messageInput'],
            ]);

            $mailer = new Mailer();

            $mailer->sendMail('Un utilisateur de DevCoding vous a envoyé un message', AppConfig::CONTACT_FORM_EMAIL, $message);

            $session->set('successFlash', 'Votre email à bien été envoyé, nous répondrons dans les plus brefs délai.');

            $form->clearData();
        }

        // Votre nom et votre prénom ;
        // Une photo et/ou un logo ;
        // Une phrase d’accroche qui vous ressemble (exemple : “Martin Durand, le développeur qu’il vous faut !”)
        // Un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
        // Un formulaire de contact (à la soumission de ce formulaire, un e-mail avec toutes ces informations vous sera envoyé) avec les champs suivants :
        // E-mail de contact,
        // message,
        // Un lien vers votre CV au format PDF ;
        // Et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (GitHub, LinkedIn, Twitter…).

        return $this->render('/home/home.php', [
            'posts' => $resultPosts,
            'postsPromote' => $postsPromote,
            'form' => $form->getData(),
        ]);
    }
}
