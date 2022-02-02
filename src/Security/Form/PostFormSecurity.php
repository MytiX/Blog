<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class PostFormSecurity extends FormSecurity
{
    public array $configInput = [
        'title' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^.{1,255}$/',
            'constraintError' => 'La longueur du titre est incorrecte, Maximum 255 caractères',
        ],
        'header' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^.{1,255}+$/',
            'constraintError' => 'La longueur du châpo est incorrecte, Maximum 255 caractères',
        ],
        'slug' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/^[a-z-]{1,255}$/',
            'constraintError' => 'Le slug ne peut comporter uniquement des lettres minuscule et des tirets -',
        ],
        'content' => [
            'type' => 'string',
            'nullable' => false,
            'constraint' => '/.+/',
            'constraintError' => 'Veuillez renseignez le champs ci-dessous',
        ],
        'image' => [
            'type' => 'file',
            'class' => 'App\Core\Uploads\UploadImage',
            'function' => 'isValid',
            'nullable' => false,
            'constraintError' => 'Veuillez insérer une image',
        ],
        'active' => [
            'type' => 'checkbox',
            'nullable' => true,
            'constraint' => '/^[1]{1}$/',
            'constraintError' => 'Veuillez cocher la case',
        ],
        'promote' => [
            'type' => 'checkbox',
            'nullable' => true,
            'constraint' => '/^[1]{1}$/',
            'constraintError' => 'Veuillez cocher la case',
        ],
    ];
}
