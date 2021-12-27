<?php

namespace App\Entity;

use App\Core\ORM\ActiveRecord;
use App\Core\ORM\EntityReflection\EntityAttribute;
use DateTime;

class Comments extends ActiveRecord
{
    #[EntityAttribute([
        'AutoIncrement' => true,
        'Id' => true,
    ])]
    private ?int $id = null;

    private string $content;

    private string $createdAt;

    private int $active = 0;

    private int $idPost;

    private int $idUser;

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): Datetime
    {
        return new DateTime($this->createdAt);
    }

    public function setActive($active): void
    {
        $this->active = $active;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setIdPost($idPost): void
    {
        $this->idPost = $idPost;
    }

    public function getIdPost(): int
    {
        return $this->idPost;
    }

    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }
}
