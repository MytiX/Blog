<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Core\Uploads\UploadImage;
use App\Entity\Posts;
use App\Security\Form\PostFormSecurity;
use Config\AppConfig;
use DateTime;
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
            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }

        /** @var Posts $post */
        $post = (new Posts())->findOneBy([
            'params' => [
                'id' => $id,
            ],
        ]);

        if (null !== $post) {
            $post->delete();

            ($this->getSession())->set('successFlash', "L'article numéro $id a bien été supprimer");

            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }
    }

    #[Route('/admin/post/edit/{id}')]
    public function editPost($id): Response
    {
        /** @var Posts $post */
        $post = (new Posts())->find($id);

        if (null === $post) {
            $this->getSession()->set('errorFlash', "Cet article n'existe pas");

            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }

        $formData = [
            'title' => $post->getTitle(),
            'header' => $post->getHeader(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'image' => $post->getimage(),
            'promote' => $post->getPromote(),
            'active' => $post->getActive(),
        ];

        $form = new PostFormSecurity($this->getRequest(), $this->getSession());

        $form->setConfigInput('image', 'nullable', true);

        if ($form->isValid() && $form->isSubmit()) {
            $formData = $form->getData();

            $session = $this->getSession();

            $user = $session->get('__user');

            $date = (new DateTime())->format('Y-m-d H:i:s');

            $post->setTitle($formData['title']);
            $post->setHeader($formData['header']);
            $post->setSlug($formData['slug']);
            $post->setContent($formData['content']);
            $post->setAuthor($user['id']);
            $post->setUpdateAt($date);

            if (array_key_exists('promote', $formData)) {
                $post->setPromote(1);
            } else {
                $post->setPromote(0);
            }

            if (array_key_exists('active', $formData)) {
                $post->setActive(1);
            } else {
                $post->setActive(0);
            }

            if (null !== ($image = $formData['image'])) {
                /* @var UploadImage $image */
                $image->uploadFile('image', $post->getId());

                $post->setImage($image->getFilename());
            }

            $post->save();

            $session->set('successFlash', "L'article à bien été mis à jour !");

            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }

        return $this->render('/admin/posts/editPost.php', [
            'post' => $formData,
            'edit' => true,
        ]);
    }

    #[Route('/admin/post/add')]
    public function addPost(): Response
    {
        $request = $this->getRequest();

        $session = $this->getSession();

        $form = new PostFormSecurity($request, $session);

        if ($form->isSubmit() && $form->isValid()) {
            $user = $session->get('__user');

            $formData = $form->getData();

            $post = new Posts();

            $date = (new DateTime())->format('Y-m-d H:i:s');

            $post->setTitle($formData['title']);
            $post->setHeader($formData['header']);
            $post->setSlug($formData['slug']);
            $post->setContent($formData['content']);
            $post->setAuthor($user['id']);
            $post->setCreatedAt($date);
            $post->setUpdateAt($date);

            if (array_key_exists('promote', $formData)) {
                $post->setPromote(1);
            } else {
                $post->setPromote(0);
            }

            if (array_key_exists('active', $formData)) {
                $post->setActive(1);
            } else {
                $post->setActive(0);
            }

            $post->save();

            /** @var UploadImage $image */
            $image = $formData['image'];

            $image->uploadFile('image', $post->getId());

            $post->setImage($image->getFilename());

            $post->save();

            $session->set('successFlash', "L'article à bien été créer !");

            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }

        return $this->render('/admin/posts/editPost.php', [
            'post' => $form->getData(),
            'edit' => false,
        ]);
    }
}
