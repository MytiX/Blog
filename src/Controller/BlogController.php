<?php

namespace App\Controller;

use App\Core\Route\Route;
use App\Core\Controller\AbstractController;

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
        return $this->render("/home/home.php");
    }

    #[Route("/blog/{slug}")]
    public function viewPost(string $slug)
    {
        dd(__CLASS__ . " " . $slug);
        // echo __CLASS__ . " Article : " . $slug;
        // Tous les requis pour la page d'affichage de tous les blogs posts

        // Le titre ;
        // Le chapô ;
        // Le contenu ;
        // L’auteur ;
        // La date de dernière mise à jour ;
        // Le formulaire permettant d’ajouter un commentaire (soumis pour validation) ;
        // Les listes des commentaires validés et publiés.
        return $this->render("/home/home.php");
    }

    public function addPost()
    {
        // Ajout d'un Article
    }

    public function editPost(int $idPost)
    {
        // Modification d'un article
    }

    public function deletePost(int $idPost)
    {
        // Suppression d'un article
    }

}