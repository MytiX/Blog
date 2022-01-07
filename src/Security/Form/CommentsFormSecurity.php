<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class CommentsFormSecurity extends FormSecurity
{
    public array $configInput = [
        'content' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[^<>]{1,500}$/',
            'constraintError' => 'Les caractères <> ne sont pas supporté ou la longueur du commentaire trop long 500 caractères maximum',
        ],
    ];
}

