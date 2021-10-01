<?php

namespace App\Entity;

class User
{
    private int $id;

    private string $name;

    private string $nomArticle;

    // private ?string $prenom;

    // private ?int $age;

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

    public function setNomArticle(string $nomArticle): void
    {
        $this->nomArticle = $nomArticle;
    }
    public function getNomArticle(): string
    {
        return $this->nomArticle;
    }

    // public function setPrenom(string $prenom): void
    // {
    //     $this->prenom = $prenom;
    // }
    // public function getPrenom(): string
    // {
    //     return $this->prenom;
    // }

    // public function setAge(int $age): void
    // {
    //     $this->age = $age;
    // }
    // public function getAge(): string
    // {
    //     return $this->age;
    // }
}