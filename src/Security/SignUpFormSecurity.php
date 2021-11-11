<?php

namespace App\Security;

use App\Core\FormSecurity\FormSecurity;

class SignUpFormSecurity extends FormSecurity
{
    protected array $configInput = [
        'pseudoInput' => [
            'isNull' => false,
            'constraint' => '/^([a-zA-Z0-9_]{4,16})$/'
        ],
        'emailInput' => [
            'isNull' => false,
            'constraint' => '/^[a-zA-Z0-9-_.]+[@]{1}[a-zA-Z0-9-]+[.]{1}[a-z]{2,4}$/'
        ],
        'passwordInput' => [
            'isNull' => false,
            'constraint' => ''
        ],
        'cPasswordInput' => [
            'isNull' => false,
            'constraint' => ''
        ],
        'checkInput' => [
            'isNull' => false,
            'constraint' => ''
        ],
    ];
}
