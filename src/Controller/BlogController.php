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

    public function viewAllPosts(): Response
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

        $post->setUser($author);

        $form = new CommentsFormSecurity($this->getRequest(), $this->session);

        $comments = new Comments();

        if ($form->isSubmit() && $form->isValid()) {
            if (null === ($user = $this->session->get(AppConfig::USER_SESSION))) {
                return new RedirectResponse(AppConfig::URL);
            }

            $data = $form->getData();

            $comments->setContent(htmlspecialchars($data['content']));
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
            'orderBy' => [
                'created_at ASC'
            ]
        ]);

        if ($comments) {
            foreach ($comments as $comment) {
                $user = (new Users())->find($comment->getIdUser());
                $comment->setUser($user);
            }
        }

        return $this->render('/post/post.php', [
            'post' => $post,
            'comments' => $comments,
            'form' => $form->getData(),
        ]);
    }
}
