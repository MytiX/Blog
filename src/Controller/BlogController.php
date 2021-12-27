<?php

namespace App\Controller;

use DateTime;
use App\Entity\Posts;
use App\Entity\Users;
use App\Entity\Comments;
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
        return $this->render('/home/home.php');
    }

    #[Route('/blog/{slug}-{id}')]
    public function viewPost(string $slug, int $id)
    {
        $post = (new Posts())->find($id);

        $author = (new Users())->find($post->getAuthor());

        $comments = (new Comments())->findBy([
            'params' => [
                'id_post' => $post->getId(),
                'active' => 1,
            ],
        ]);

        $resultComments = [];

        foreach ($comments as $comment) {

            /** @var Comments $comment */
            /** @var Users $user */
            /** @var Posts $post */

            $user = (new Users)->find($comment->getIdUser());

            $resultComments[] = [
                'content' => $comment->getContent(),
                'pseudo' => $user->getPseudo(),
            ];
        }

        $postResult = [
            'title' => $post->getTitle(),
            'author' => $author->getPseudo(),
            'date' => (new DateTime($post->getUpdateAt()))->format('d/m/Y'),
            'img' => $post->getImage(),
            'content' => $post->getContent(),
            'comments' => $resultComments,
        ];

        return $this->render('/post/post.php', [
            'post' => $postResult,
        ]);
    }
}
