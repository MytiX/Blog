<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Entity\Posts;

class BlogController extends AbstractController
{
    public function viewAllPosts()
    {
        // echo 'View All Posts';
        // Tous les requis pour la page d'affichage de tous les blogs posts

        // Le titre ;
        // La date de dernière modification ;
        // Le châpo ;
        // Lien vers le blog post.
        return $this->render('/home/home.php');
    }

    #[Route('/blog/{slug}-{id}')]
    public function viewPost(string $slug, int $id)
    {
        $post = new Posts();

        $resultPost = $post->find($id);

        // dd($resultPost);
        // dd(__CLASS__ . " " . $slug);
        // echo __CLASS__ . " Article : " . $slug;
        // Tous les requis pour la page d'affichage de tous les blogs posts

        // Le titre ;
        // Le chapô ;
        // Le contenu ;
        // L’auteur ;
        // La date de dernière mise à jour ;
        // Le formulaire permettant d’ajouter un commentaire (soumis pour validation) ;
        // Les listes des commentaires validés et publiés.
        return $this->render('/post/post.php', [
            'post' => $resultPost,
        ]);
    }
}
