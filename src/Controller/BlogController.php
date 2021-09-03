<?php

namespace App\Controller;

class BlogController 
{

    public function viewAllPosts()
    {
        echo 'View All Posts';
        // Tous les requis pour la page d'affichage de tous les blogs posts

        // Le titre ;
        // La date de dernière modification ;
        // Le châpo ;
        // Lien vers le blog post.
    }
    
    public function viewPost(string $slug)
    {
        echo __CLASS__ . " Article : " . $slug;
        // Tous les requis pour la page d'affichage de tous les blogs posts

        // Le titre ;
        // Le chapô ;
        // Le contenu ;
        // L’auteur ;
        // La date de dernière mise à jour ;
        // Le formulaire permettant d’ajouter un commentaire (soumis pour validation) ;
        // Les listes des commentaires validés et publiés.
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