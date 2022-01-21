<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class ContactFormSecurity extends FormSecurity
{
    public array $configInput = [
        'emailInput' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^[a-zA-Z0-9-_.+]+[@]{1}[a-zA-Z0-9-]+[.]{1}[a-z]{2,4}$/',
            'constraintError' => 'Veuillez renseignez une adresse mail valide',
        ],
        'objetInput' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^[^<>]{1,255}$/',
            'constraintError' => 'Les caractères <> ne sont pas supporté ou longueur de votre objet est incorrect maximum 255 caractères',
        ],
        'messageInput' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/.+/',
            'constraintError' => 'Veuillez renseignez le champs ci-dessous',
        ],
        'checkInput' => [
            'type' => 'checkbox',
            'nullable' => false,
            'constraint' => '/^[1]{1}$/',
            'constraintError' => 'Veuillez cocher la case des CGU',
        ],
    ];
}
