<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;

class DeviceSummaryModel
{
    private ?int $id = null;
    private ?string $name = null;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /* 
    public function getLinks(): ?array
    {
        return $this->links;
    }

    public function setLinks(int $id): static
    {
        $this->links = [
            'href' => (string) '/api/devices/' . $id
        ];
        return $this;
    }*/

}
