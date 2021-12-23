<?php

namespace App\Controller;

use DateTime;
use App\Entity\Posts;
use Config\AppConfig;
use App\Core\Route\Route;
use App\Security\Form\PostFormSecurity;
use App\Core\Controller\AbstractController;
use App\Core\Uploads\UploadImage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        /** @var Posts $post */
        $post = (new Posts())->find($id);

        if (null === $post) {

            $this->getSession()->set('errorFlash', "Cet article n'existe pas");

            return new RedirectResponse(AppConfig::URL . '/admin/posts');
        }

        $form = new PostFormSecurity($this->getRequest(), $this->getSession());

        if ($form->isSubmit()) {

            $formPost = $form->getData();

            if ($form->isValid()) {

                $session = $this->getSession();

                $user = $session->get('__user');

                $date = (new DateTime())->format('Y-m-d H:i:s');

                $post->setTitle($formPost->getTitle());
                $post->setHeader($formPost->getHeader());
                $post->setSlug($formPost->getSlug());
                $post->setContent($formPost->getContent());
                $post->setAuthor($user['id']);
                $post->setUpdateAt($date);

                $post->save();

                $session->set('successFlash', "L'article à bien été mis à jour !");

                return new RedirectResponse(AppConfig::URL . '/admin/posts');
            }
        }

        return $this->render('/admin/posts/editPost.php', [
            'post' => isset($formPost) ? $formPost : $post,
        ]);
    }

    #[Route('/admin/post/add')]
    public function addPost(): Response
    {
        $request = $this->getRequest();

        $session = $this->getSession();

        $form = new PostFormSecurity($request, $session);

        // $uploadsImage = new UploadImage($request, $session);

        if ($form->isSubmit() && $form->isValid()) {
            $user = $session->get('__user');

            $post = $form->getData();

            $date = (new DateTime())->format('Y-m-d H:i:s');

            $post->setAuthor($user['id']);
            $post->setCreatedAt($date);
            $post->setUpdateAt($date);
            $post->setActive(1);
            $post->setPromote(1);
            /** @var UploadImage $image */
            $image = $post->getImage();
            $post->setImage(null);

            $post->save();

            $image->uploadFile('image', $post->getId());

            $post->setImage($image->getFilename());

            $post->save();

            $session->set('successFlash', "L'article à bien été créer !");

            return new RedirectResponse(AppConfig::URL . '/admin/posts');

        }

        return $this->render('/admin/posts/editPost.php', [
            'post' => $form->getData(),
        ]);
    }
}
