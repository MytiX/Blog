<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class CommentsFormSecurity extends FormSecurity
{
    public array $configInput = [
        'content' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^.{1,500}$/',
            'constraintError' => 'La longueur du commentaire est trop longue 500 caractères maximum',
        ],
    ];
}
