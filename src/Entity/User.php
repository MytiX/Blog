<?php

namespace App\Entity;

use App\Core\ORM\ActiveRecord;

class User extends ActiveRecord
{
    private ?int $id;

    private ?string $name;

    // private string $prenom;

    public function setId($id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }

    // public function setPrenom($prenom): void
    // {
    //     $this->prenom = $prenom;
    // }
    // public function getPrenom(): string
    // {
    //     return $this->prenom;
    // }
}