<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;


class ClientSummaryModel
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

    public function getLinks(): array
    {
        return $this->links;
    }

    public function setLinks(int $id): static
    {
        $this->links = [
            '_links' => [
                'self' => (string) '/api/clients',
                'href' => (string) '/api/clients/' . $id,
            ],
            'title' => 'H.A.T.E.O.A.S & Resource Linking'
        ];
        return $this;
    }

}
