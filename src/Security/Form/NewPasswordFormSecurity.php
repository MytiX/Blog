<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class NewPasswordFormSecurity extends FormSecurity
{
    public array $configInput = [
        'passwordInput' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^[^\s]{8,16}$/',
            'constraintError' => 'Le mot de passe doit avoir une longueur entre 8 et 16 caractères',
        ],
        'cPasswordInput' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^[^\s]{8,16}$/',
            'constraintError' => 'Le mot de passe doit avoir une longueur entre 8 et 16 caractères',
        ],
    ];
}
