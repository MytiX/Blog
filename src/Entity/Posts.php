<?php

namespace App\Entity;

use App\Core\ORM\ActiveRecord;
use App\Core\ORM\EntityReflection\EntityAttribute;
use DateTime;

class Posts extends ActiveRecord
{
    #[EntityAttribute([
        'AutoIncrement' => true,
        'Id' => true,
    ])]
    private int $id;

    private string $title;

    private string $slug;

    private string $header;

    private string $content;

    private int $author;

    private string $createdAt;

    private string $updateAt;

    private int $active;

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): string
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

    public function getUpdateAt(): string
    {
        return $this->updateAt;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getActive(): int
    {
        return $this->active;
    }
}
