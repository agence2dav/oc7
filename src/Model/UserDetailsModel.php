<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;

class UserDetailsModel
{
    private ?int $id = null;
    private ?string $username = null;
    private ?string $email = null;
    private ?string $status = null;
    private ?DateTime $createdAt = null;
    private ?array $links;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->username;
    }

    public function setUserName(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /* 
    public function getUserUrl(): array
    {
        return $this->links;
    }

    public function setUserUrl(int $clientId): static
    {
        $this->links = [
            '_links' => [
                'userid' => (string) $this->getId(),
                'self' => (string) '/api/clients/' . $clientId . '/users/' . $this->id
            ]
        ];
        return $this;
    }*/

}
