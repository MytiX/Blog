<?php

namespace App\Security\Form;

use App\Core\FormSecurity\FormSecurity;

class AddPostFormSecurity extends FormSecurity
{
    protected array $configInput = [
        'titleInput' => [
            'isNull' => false,
            'constraint' => '/^[^<>]{1,255}$/',
            'constraintError' => 'Les caractères <> ne sont pas supporté ou longueur du titre incorrect maximum 255 caractères',
        ],
        'teaserInput' => [
            'isNull' => false,
            'constraint' => '/^[^<>]+$/',
            'constraintError' => 'Les caractères <> ne sont pas supporté',
        ],
        'slugInput' => [
            'isNull' => false,
            'constraint' => '/^[a-z-]{1,255}$/',
            'constraintError' => 'Le slug ne peut comporter uniquement des lettres minuscule et du tiret -',
        ],
        'contentInput' => [
            'isNull' => false,
            'constraint' => '/^.+$/',
            'constraintError' => 'Veuillez renseignez le champs ci-dessous',
        ],
    ];
}
