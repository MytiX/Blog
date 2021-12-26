<?php

namespace App\Entity;

use App\Core\ORM\ActiveRecord;
use App\Core\ORM\EntityReflection\EntityAttribute;

class Users extends ActiveRecord
{
    #[EntityAttribute([
        'AutoIncrement' => true,
        'Id' => true,
    ])]
    private ?int $id = null;

    private string $email;

    private string $password;

    private string $pseudo;

    // private string $firstname;

    // private string $lastname;

    private string $role = 'ROLE_USER';

    private string $createdAt;

    private int $active = 0;

    private ?string $codeAuth = null;

    private ?string $resetPassRequest = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    // public function setFirstname(string $firstname): void
    // {
    //     $this->firstname = $firstname;
    // }

    // public function getFirstname(): string
    // {
    //     return $this->firstname;
    // }

    // public function setLastname(string $lastname): void
    // {
    //     $this->lastname = $lastname;
    // }

    // public function getLastname(): string
    // {
    //     return $this->lastname;
    // }

    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCodeAuth(?string $codeAuth): void
    {
        $this->codeAuth = $codeAuth;
    }

    public function getCodeAuth(): ?string
    {
        return $this->codeAuth;
    }

    public function setResetPassRequest(?string $resetPassRequest): void
    {
        $this->resetPassRequest = $resetPassRequest;
    }

    public function getResetPassRequest(): ?string
    {
        return $this->resetPassRequest;
    }
}
