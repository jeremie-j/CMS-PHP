<?php

namespace App\Entity;

class User
{
    private string $id;
    private string $username;
    private string $password;
    private \DateTime $createdAt;
    private bool $admin;

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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAdmin(): string
    {
        return $this->admin;
    }

    public function setAdmin(string $admin): void
    {
        $this->admin = $admin;
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
