<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class PostFormSecurity extends FormSecurity
{
    protected array $configInput = [
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
            'isNull' => false,
            'class' => 'App\Core\Uploads\UploadImage',
            'function' => 'isValid',
            'params' => [
                'nullable' => false
            ],
        ],
    ];

    protected function getDataClass(): string
    {
        return 'App\Entity\Posts';
    }
}
