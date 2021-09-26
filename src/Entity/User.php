<?php

namespace App\Entity;

use App\Core\ORM\ActiveRecord;

class User extends ActiveRecord
{
    private ?int $id;

    private ?string $name;

    private ?string $prenom;

    private ?int $age;

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }
    public function getAge(): string
    {
        return $this->age;
    }
}