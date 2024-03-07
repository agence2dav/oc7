<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FirstRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: FirstRepository::class)]
#[ApiResource]
#[Broadcast]
class First
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Second::class, mappedBy: 'parent')]
    private Collection $seconds;

    public function __construct()
    {
        $this->seconds = new ArrayCollection();
    }

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

    public function getSeconds(): Collection
    {
        return $this->seconds;
    }

    public function addSecond(Second $second): static
    {
        if (!$this->seconds->contains($second)) {
            $this->seconds->add($second);
            $second->setParent($this);
        }
        return $this;
    }

    public function removeSecond(Second $second): static
    {
        if ($this->seconds->removeElement($second)) {
            // set the owning side to null (unless already changed)
            if ($second->getParent() === $this) {
                $second->setParent(null);
            }
        }
        return $this;
    }
}
