<?php

namespace App\Security\Authentication;


class Authentication
{
    public const SESSION_USER_KEY = '__user';

    public function attemptLogin(array $credentials)
    {
        if (null !== ($user = $this->getUser($credentials))) {
            // mise en session de l'utilisateur

            return true;
        }

        return false;
    }

    public function getUser(array $credentials): ?User
    {
        // Test de recup de l'utilisateur en fonction de l'email

        // Vérification du mot de passe
    }
}
