<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SecondRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: SecondRepository::class)]
#[ApiResource]
#[Broadcast]
class Second
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'seconds')]
    private ?First $parent = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParent(): ?First
    {
        return $this->parent;
    }

    public function setParent(?First $parent): static
    {
        $this->parent = $parent;

        return $this;
    }
}
