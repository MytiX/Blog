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
        $page = 1;
        $limit = 2;

        $posts = (new Posts())->findBy([
            'params' => [
                'active' => 1
            ],
        ]);
        return $this->render('/post/all-post.php', [
            'posts' => $posts,
        ]);
    }
}

