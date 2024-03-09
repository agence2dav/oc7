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

    public function setClientName(string $clientname): static
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

}
