<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Entity\Posts;
use App\Entity\Users;

class HomeController extends AbstractController
{
    #[Route('/', 'app_home')]
    public function home()
    {
        // $user = new Users();
        $posts = new Posts();

        $resultPosts = $posts->findBy('active', 1);

        // dd($resultPosts);

        // dd($resultPosts);

        // for ($i=1; $i < 50; $i++) {
        //     $date = new DateTime();

        //     $article->setTitle("Article PHP N°" . $i);
        //     $article->setHeader("Introduction article N°" . $i);
        //     $article->setContent("Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea veritatis delectus ullam, voluptatibus totam cumque suscipit quas alias facilis, corrupti explicabo illo corporis laborum iste rerum eos debitis odio porro.");
        //     $article->setAuthor(1);
        //     $article->setCreatedAt($date->format('Y-m-d H:i:s'));
        //     $article->setUpdateAt($date->format('Y-m-d H:i:s'));
        //     $article->setActive(1);

        //     $article->save();
        // }

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
        ]);
    }
}
