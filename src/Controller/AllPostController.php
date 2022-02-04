<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Entity\Posts;
use Symfony\Component\HttpFoundation\Response;

class AllPostController extends AbstractController
{
    #[Route('/all-post')]
    public function index(): Response
    {
        $request = $this->getRequest();

        $page = 0;
        $limit = 2;
        $moreResult = false;

        if (null !== ($pageNumber = $request->query->get('page')) && is_numeric($pageNumber) && $pageNumber > 0) {
            $page = $pageNumber - 1;
        }

        $posts = (new Posts())->findBy([
            'params' => [
                'active' => 1,
            ],
            'limit' => $limit + 1,
            'offset' => $page * $limit,
            'orderBy' => [
                'id DESC',
            ],
        ]);

        if (null !== $posts && count($posts) > $limit) {
            $moreResult = true;
            unset($posts[array_key_last($posts)]);
        }

        return $this->render('/post/all-post.php', [
            'posts' => $posts,
            'moreResult' => $moreResult,
            'page' => $page + 1,
        ]);
    }
}
