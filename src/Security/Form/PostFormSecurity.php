<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class PostFormSecurity extends FormSecurity
{
    public array $configInput = [
        'title' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[^<>]{1,255}$/',
            'constraintError' => 'Les caractères <> ne sont pas supporté ou longueur du titre incorrect maximum 255 caractères',
        ],
        'header' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[^<>]+$/',
            'constraintError' => 'Les caractères <> ne sont pas supporté',
        ],
        'slug' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/^[a-z-]{1,255}$/',
            'constraintError' => 'Le slug ne peut comporter uniquement des lettres minuscule et du tiret -',
        ],
        'content' => [
            'type' => 'string',
            'isNull' => false,
            'constraint' => '/.+/',
            'constraintError' => 'Veuillez renseignez le champs ci-dessous',
        ],
        'image' => [
            'type' => 'file',
            'class' => 'App\Core\Uploads\UploadImage',
            'function' => 'isValid',
            'nullable' => false
        ],
        'active' => [
            'type' => 'checkbox',
            'constraint' => '/^[1]{1}$/',
            'constraintError' => 'Une erreur est survenue sur ce champs',
        ],
        'promote' => [
            'type' => 'checkbox',
            'constraint' => '/^[1]{1}$/',
            'constraintError' => 'Une erreur est survenue sur ce champs',
        ],
    ];
}
