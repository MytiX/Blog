<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Entity\Posts;

class HomeController extends AbstractController
{
    #[Route('/', 'app_home')]
    public function home()
    {
        $posts = new Posts();

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
        ]);
    }
}
