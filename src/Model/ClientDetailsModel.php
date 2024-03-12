<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;
use App\Entity\DeviceProp;
use App\Entity\Device;

class ClientDetailsModel
{
    private ?int $id = null;
    private ?string $corporation = null;
    private ?string $email = null;
    private array $links;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getCorporation(): ?string
    {
        return $this->corporation;
    }

    public function setCorporation(string $corporation): static
    {
        $this->corporation = $corporation;
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

    public function getClientUsers(): array
    {
        return $this->links;
    }

    public function setClientUsers(array $users): static
    {
        $links = [];
        foreach ($users as $user) {
            $links[] = [
                'userid' => (string) $user->getId(),
                'username' => (string) $user->getUsername(),
                'href' => (string) '/api/clients/' . $this->id . '/users/' . $user->getId()
            ];
        }
        $this->links = ['_links' => $links];
        return $this;
    }

}
