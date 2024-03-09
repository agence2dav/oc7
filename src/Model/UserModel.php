<?php

declare(strict_types=1);

namespace App\Model;

use DateTimeInterface;

class UserModel
{
    private ?int $id = null;
    private ?string $clientname = null;
    private ?string $email = null;
    private ?string $status = null;
    private ?DateTimeInterface $createdAt = null;

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
        return $this->clientname;
    }

    public function setUserName(string $clientname): static
    {
        $this->clientname = $clientname;
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

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}
