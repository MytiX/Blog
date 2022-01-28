<?php

namespace App\Entity;

use App\Core\ORM\ActiveRecord;
use App\Core\ORM\EntityReflection\EntityAttribute;
use DateTime;

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

    private string $role = 'ROLE_USER';

    private string $createdAt;

    private int $active = 0;

    private ?string $codeAuth = null;

    private ?string $resetPassCode = null;

    private ?string $resetPassCreatedAt = null;

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

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->createdAt);
    }

    public function setCodeAuth(?string $codeAuth): void
    {
        $this->codeAuth = $codeAuth;
    }

    public function getCodeAuth(): ?string
    {
        return $this->codeAuth;
    }

    public function setResetPassCode(?string $resetPassCode): void
    {
        $this->resetPassCode = $resetPassCode;
    }

    public function getResetPassCode(): ?string
    {
        return $this->resetPassCode;
    }

    public function setResetPassCreatedAt(?string $resetPassCreatedAt): void
    {
        $this->resetPassCreatedAt = $resetPassCreatedAt;
    }

    public function getResetPassCreatedAt(): DateTime
    {
        return new DateTime($this->resetPassCreatedAt);
    }
}
