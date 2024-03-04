<?php

namespace App\Entity;

use App\Repository\PropRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Prop;

#[ORM\Entity(repositoryClass: PropRepository::class)]
class Attr
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Prop::class, mappedBy: 'attr')]
    private Collection $props;

    public function __construct()
    {
        $this->props = new ArrayCollection();
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

    public function getProps(): Collection
    {
        return $this->props;
    }

    public function addProp(Prop $prop): static
    {
        if (!$this->props->contains($prop)) {
            $this->props->add($prop);
            $prop->setAttr($this);
        }
        return $this;
    }

    public function removeProp(Prop $prop): static
    {
        if ($this->props->removeElement($prop)) {
            // set the owning side to null (unless already changed)
            if ($prop->getAttr() === $this) {
                $prop->setAttr(null);
            }
        }
        return $this;
    }

}
