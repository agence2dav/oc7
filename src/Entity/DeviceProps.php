<?php

namespace App\Entity;

use App\Entity\Attr;
use App\Entity\Prop;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\UX\Turbo\Attribute\Broadcast;
use App\Repository\DevicePropsRepository;

#[ORM\Entity(repositoryClass: DevicePropsRepository::class)]
#[ApiResource]
#[Broadcast]
class DeviceProps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'deviceProps')]
    private ?Device $device = null;

    #[ORM\ManyToOne(inversedBy: 'deviceProps')]
    private ?Prop $prop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): static
    {
        $this->device = $device;
        return $this;
    }

    public function getProp(): ?Prop
    {
        return $this->prop;
    }

    public function setProp(?Prop $prop): static
    {
        $this->prop = $prop;
        return $this;
    }

}
