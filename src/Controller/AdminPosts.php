<?php

namespace App\Controller;

use App\Core\Route\Route;
use App\Core\Controller\AbstractController;
use App\Entity\Posts;
use App\Security\Form\AddPostFormSecurity;
use Config\AppConfig;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminPosts extends AbstractController
{
    #[Route('/admin/posts')]
    public function getAllPosts(): Response
    {
        $posts = (new Posts())->findAll();

        return $this->render('/admin/posts/allPosts.php', [
            'posts' => $posts,
        ]);
    }

    #[Route('/admin/post/delete/{id}')]
    public function deletePost(int $id): RedirectResponse
    {
        if (!is_numeric($id)) {
            return new RedirectResponse(AppConfig::URL . '/admin/posts');
        }

        /** @var Posts $post */
        $post = (new Posts())->findOneBy([
            'params' => [
                'id' => $id
            ]
        ]);

        if (null !== $post) {
            $post->delete();

            ($this->getSession())->set('successFlash', "L'article numéro $id a bien été supprimer");

            return new RedirectResponse(AppConfig::URL . '/admin/posts');
        }
    }

    #[Route('/admin/post/edit/{id}')]
    public function editPost($id): Response
    {
        // @TODO Créer l'edition

        return $this->render('/admin/posts/allPosts.php', []);
    }

    #[Route('/admin/post/add')]
    public function addPost(): Response
    {
        //  @TODO Créer l'insertion en base de données
        $form = new AddPostFormSecurity($this->getRequest());

        if ($form->isSubmit() && $form->isValid()) {
            dd($form->getData());
        }


        return $this->render('/admin/posts/addPost.php', []);
    }
}

