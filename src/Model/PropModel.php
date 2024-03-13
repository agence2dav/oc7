<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Attr;

class PropModel
{
    private int $id;
    private int $deviceId;
    private ?string $name = null;
    private ?array $link;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getDeviceId(): int
    {
        return $this->deviceId;
    }

    public function setDeviceId(int $deviceId): static
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getLinks(): ?array
    {
        return $this->link;
    }

    public function setLinks(Attr $attr): static
    {
        $this->link = [
            'self' => (string) '/api/devices/property/' . $this->getId(),
            'href' => (string) '/api/devices/property/attribut/' . $attr->getId()
        ];
        return $this;
    }

}
