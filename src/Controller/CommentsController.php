<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Entity\Comments;
use Config\AppConfig;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentsController extends AbstractController
{
    #[Route('/admin/comment/validate/{id}')]
    public function validate(int $id): RedirectResponse
    {
        /** @var Comments $comments */
        if (null === ($comments = (new Comments())->find($id))) {
            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }

        $comments->setActive(1);

        $comments->save();

        $this->getSession()->set('comments', 'Le commentaire à bien été validé');

        return new RedirectResponse($this->getRequest()->server->get('HTTP_REFERER'));
    }

    #[Route('/admin/comment/delete/{id}')]
    public function delete(int $id): RedirectResponse
    {
        /** @var Comments $comments */
        if (null === ($comments = (new Comments())->find($id))) {
            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }

        $comments->delete();

        $this->getSession()->set('comments', 'Le commentaire à bien été supprimé');

        return new RedirectResponse($this->getRequest()->server->get('HTTP_REFERER'));
    }

    #[Route('/admin/comment/disable/{id}')]
    public function disable(int $id): RedirectResponse
    {
        /** @var Comments $comments */
        if (null === ($comments = (new Comments())->find($id))) {
            return new RedirectResponse(AppConfig::URL.'/admin/posts');
        }

        $comments->setActive(0);
        $comments->save();

        $this->getSession()->set('comments', 'Le commentaire à bien été désactiver');

        return new RedirectResponse($this->getRequest()->server->get('HTTP_REFERER'));
    }
}
