<?php

namespace App\Core\Controller;

use App\Core\Session\Session;
use App\Core\Templating\Templating;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    private Request $request;

    /**
     * render
     * Return Response with the view
     * @param  string $file
     * @param  array $args
     * @param  int $statusCode
     * @return Response
     */
    protected function render(string $file, array $args = [], int $statusCode = 200): Response
    {
        $template = new Templating();

        $args = array_merge($args, [
            'session' => $this->getSession(),
        ]);

        return new Response($template->getView($file, $args), $statusCode);
    }

    /**
     * setRequest
     * Set request used on class Application
     * @param  mixed $request
     * @return void
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * getRequest
     * Return Http foundation Request
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * getSession
     * Return a Session object is a Singleton
     * @return Session
     */
    protected function getSession(): Session
    {
        return Session::getSession();
    }
}
