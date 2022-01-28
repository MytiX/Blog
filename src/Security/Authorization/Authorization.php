<?php

namespace App\Security\Authorization;

use Config\AppConfig;
use App\Core\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Authorization
{
    public static function access(array $roles): bool|RedirectResponse
    {
        if (empty($roles)) {
            return true;
        }

        $session = Session::getSession();

        if (empty($user = $session->get(AppConfig::USER_SESSION))) {
            return new RedirectResponse(AppConfig::URL.'/signin');
        }

        if (!in_array($user['role'], $roles)) {
            $session->set('accessDenied', 'Accès non autorisée');
            return new RedirectResponse(AppConfig::URL);
        }
        return true;
    }
}
