<?php

namespace App\Entity;

use DateTime;
use App\Core\ORM\ActiveRecord;
use App\Core\ORM\EntityReflection\EntityAttribute;

class Posts extends ActiveRecord
{
    #[EntityAttribute([
        'AutoIncrement' => true,
        'Id' => true,
    ])]
    private int $id;

    private ?string $title = null;

    private ?string $slug = null;

    private ?string $header = null;

    private ?string $content = null;

    private int $author;

    private string $createdAt;

    private string $updateAt;

    private int $active;

    private int $promote;

    private ?string $image = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        if (empty($this->id)) {
            return null;
        }

        return $this->id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    public function getAuthor(): int
    {
        return $this->author;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->createdAt);
    }

    public function setUpdateAt(string $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    public function getUpdateAt(): DateTime
    {
        return new DateTime($this->updateAt);
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setPromote(int $promote): void
    {
        $this->promote = $promote;
    }

    public function getPromote(): int
    {
        return $this->promote;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
