<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class SignInFormSecurity extends FormSecurity
{
    public array $configInput = [
        'emailInput' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[a-zA-Z0-9-_.+]+[@]{1}[a-zA-Z0-9-]+[.]{1}[a-z]{2,4}$/',
            'constraintError' => 'Veuillez renseignez une adresse mail valide',
        ],
        'passwordInput' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[^\s]{8,16}$/',
        ],
    ];
}
