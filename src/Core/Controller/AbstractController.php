<?php

namespace App\Core\Controller;

use App\Core\Session\Session;
use App\Core\Templating\Templating;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    private Request $request;

    protected function render(string $file, array $args = [], int $statusCode = 200)
    {
        $template = new Templating();

        $args = array_merge($args, [
            'session' => $this->getSession(),
        ]);

        return new Response($template->getView($file, $args), $statusCode);
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    protected function getSession(): Session
    {
        return Session::getSession();
    }
}
