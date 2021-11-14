<?php

namespace App\Security;

use App\Core\FormSecurity\FormSecurity;

class SignUpFormSecurity extends FormSecurity
{
    protected array $configInput = [
        'pseudoInput' => [
            'isNull' => false,
            'constraint' => '/^([a-zA-Z0-9_]{4,16})$/',
            'errorMessage' => 'Le champs est invalide'
        ],
        'emailInput' => [
            'isNull' => false,
            'constraint' => '/^[a-zA-Z0-9-_.]+[@]{1}[a-zA-Z0-9-]+[.]{1}[a-z]{2,4}$/'
        ],
        'passwordInput' => [
            'isNull' => false,
            'constraint' => '/^[^\s]{8,16}$/'
        ],
        'cPasswordInput' => [
            'isNull' => false,
            'constraint' => '/^[^\s]{8,16}$/'
        ],
        'checkInput' => [
            'isNull' => false,
            'constraint' => '/^[1]{1}$/'
        ],
    ];
}
