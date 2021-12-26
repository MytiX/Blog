<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use App\Entity\Users;
use Config\AppConfig;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ValidateAccount extends AbstractController
{
    #[Route('/validate-account')]
    public function validEmail()
    {
        $request = $this->getRequest();

        $email = $request->query->get('email');
        $code = $request->query->get('code');

        if (empty($email) || empty($code) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new RedirectResponse(AppConfig::URL.'/signin');
        }

        $user = new Users();

        /** @var Users $user */
        $user = $user->findOneBy([
            'params' => [
                'email' => $email,
            ],
        ]);

        if (!$user instanceof Users) {
            return new RedirectResponse(AppConfig::URL.'/signin');
        }

        if ($code == $user->getCodeAuth()) {
            $user->setActive(1);
            $user->save();
        }

        return new RedirectResponse(AppConfig::URL.'/signin');
    }
}
