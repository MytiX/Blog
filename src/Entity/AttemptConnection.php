<?php

namespace App\Entity;

use App\Core\ORM\ActiveRecord;
use App\Core\ORM\EntityReflection\EntityAttribute;

class AttemptConnection extends ActiveRecord
{
    #[EntityAttribute([
        'AutoIncrement' => true,
        'Id' => true,
    ])]
    private ?int $id = null;

    private string $ip;

    private int $attempt;

    private string $attemptAt;

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIp($ip): void
    {
        $this->ip = $ip;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setAttempt($attempt): void
    {
        $this->attempt = $attempt;
    }

    public function getAttempt(): int
    {
        return $this->attempt;
    }

    public function setAttemptAt($attemptAt): void
    {
        $this->attemptAt = $attemptAt;
    }

    public function getAttemptAt(): string
    {
        return $this->attemptAt;
    }
}

