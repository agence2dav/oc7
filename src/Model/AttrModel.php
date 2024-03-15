<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Attr;
use App\Entity\Device;
use App\Entity\DeviceProp;
use Doctrine\Common\Collections\Collection;

class AttrModel
{
    private int $id;
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

    public function setLinks(): static
    {
        $this->link = [
            'self' => (string) '/api/devices/property/attribut/' . $this->getId()
        ];
        return $this;
    }

}
