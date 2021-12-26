<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class SignUpFormSecurity extends FormSecurity
{
    public array $configInput = [
        'pseudoInput' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^([\p{L}0-9_]{4,16})$/u',
            'constraintError' => 'Votre pseudo ne peut comporter que des chiffres, des lettres et _',
        ],
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
            'constraintError' => 'Le mot de passe doit avoir une longueur entre 8 et 16 caractères',
        ],
        'cPasswordInput' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[^\s]{8,16}$/',
            'constraintError' => 'Le mot de passe doit avoir une longueur entre 8 et 16 caractères',
        ],
        'checkInput' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[1]{1}$/',
            'constraintError' => 'Veuillez cocher la case des CGU',
        ],
    ];
}
