<?php

namespace App\Entity;

use App\Repository\PropRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\DeviceProps;
use App\Entity\Attr;

#[ORM\Entity(repositoryClass: PropRepository::class)]
class Prop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'props')]
    private ?Attr $attr = null;

    #[ORM\OneToMany(targetEntity: DeviceProps::class, mappedBy: 'prop')]
    private Collection $deviceProps;

    public function __construct()
    {
        $this->deviceProps = new ArrayCollection();
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

    public function getAttr(): ?Attr
    {
        return $this->attr;
    }

    public function setAttr(?Attr $attr): static
    {
        $this->attr = $attr;
        return $this;
    }

    public function getDeviceProps(): Collection
    {
        return $this->deviceProps;
    }

    public function addDeviceProp(DeviceProps $deviceProp): static
    {
        if (!$this->deviceProps->contains($deviceProp)) {
            $this->deviceProps->add($deviceProp);
            $deviceProp->setProp($this);
        }
        return $this;
    }

    public function removeDeviceProp(DeviceProps $deviceProp): static
    {
        if ($this->deviceProps->removeElement($deviceProp)) {
            // set the owning side to null (unless already changed)
            if ($deviceProp->getProp() === $this) {
                $deviceProp->setProp(null);
            }
        }
        return $this;
    }

}
