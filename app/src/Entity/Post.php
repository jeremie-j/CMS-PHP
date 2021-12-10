<?php

namespace App\Entity;

class Post
{
    private string $id;
    private string $userId;
    private string $title;
    private string $content;
    private \DateTime $createdAt;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $method = 'set' . $key;
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        if ($createdAt instanceof \DateTime) {
            $this->createdAt = $createdAt;
        } else {
            $this->createdAt = new \DateTime($createdAt);
        }
    }
}
