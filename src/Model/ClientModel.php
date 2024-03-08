<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;
use App\Entity\DeviceProp;
use App\Entity\Device;

class ClientModel
{
    private ?int $id = null;
    private ?string $clientname = null;
    private ?string $email = null;
    private ?string $password = null;
    private array $roles = [];
    private Collection $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientname;
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

    public function setClientName(string $clientname): static
    {
        $this->clientname = $clientname;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->clientname;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): static
    {
        $this->users = $users;
        return $this;
    }

}
