<?php

namespace App\Security;

use App\Core\FormSecurity\FormSecurity;

class SignUpFormSecurity extends FormSecurity
{
    protected array $configInput = [
        'pseudoInput' => [
            'isNull' => false,
            'constraint' => '/()/'
        ],
        'emailInput' => [
            'isNull' => false,
            'constraint' => ''
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
