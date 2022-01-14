<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Core\Session\Session;
use App\Entity\Comments;
use App\Entity\Posts;
use App\Entity\Users;
use App\Security\Form\CommentsFormSecurity;
use Config\AppConfig;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    private Session $session;

    public function __construct()
    {
        $this->session = $this->getSession();
    }

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
    public function viewPost(string $slug, int $id): Response
    {
        if (null === ($post = (new Posts())->find($id))) {
            return new RedirectResponse(AppConfig::URL);
        }

        $author = (new Users())->find($post->getAuthor());

        $form = new CommentsFormSecurity($this->getRequest(), $this->session);

        $comments = new Comments();

        if ($form->isSubmit() && $form->isValid()) {
            if (null === ($user = $this->session->get('__user'))) {
                return new RedirectResponse(AppConfig::URL);
            }

            $data = $form->getData();

            $comments->setContent($data['content']);
            $comments->setActive(0);
            $comments->setCreatedAt((new DateTime())->format('Y-m-d H:i:s'));
            $comments->setIdPost($id);
            $comments->setIdUser($user['id']);

            $comments->save();

            $this->session->set('successSubmit', 'Votre commentaires à bien été soumis, il doit maintenant être validé par l\'administrateur.');
        }

        $comments = $comments->findBy([
            'params' => [
                'id_post' => $post->getId(),
                'active' => 1,
            ],
        ]);

        $resultComments = [];

        if ($comments) {
            foreach ($comments as $comment) {
                /** @var Comments $comment */
                /** @var Users $user */
                /** @var Posts $post */
                $user = (new Users())->find($comment->getIdUser());

                $resultComments[] = [
                    'content' => $comment->getContent(),
                    'pseudo' => $user->getPseudo(),
                ];
            }
        }

        $postResult = [
            'title' => $post->getTitle(),
            'author' => $author->getPseudo(),
            'date' => $post->getUpdateAt()->format('d/m/Y'),
            'img' => $post->getImage(),
            'content' => $post->getContent(),
            'comments' => $resultComments,
        ];

        return $this->render('/post/post.php', [
            'post' => $postResult,
        ]);
    }
}
