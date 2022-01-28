<?php

namespace App\Controller;

use App\Core\Route\Route;
use App\Core\Controller\AbstractController;
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

        if (!empty($r = $request->query->get('page')) && is_numeric($r) && $r > 0) {
            $page = $r - 1;
        }

        $posts = (new Posts())->findBy([
            'params' => [
                'active' => 1
            ],
            'limit' => $limit + 1,
            'offset' => $page * $limit,
            'orderBy' => [
                'id DESC'
            ],
        ]);

        if (null !== $posts && count($posts) > $limit) {
            $moreResult = true;
            unset($posts[array_key_last($posts)]);
        }

        // dd($posts, $moreResult, $limit, $page * $limit);

        return $this->render('/post/all-post.php', [
            'posts' => $posts,
            'moreResult' => $moreResult,
            'page' => $page + 1,
        ]);
    }
}

