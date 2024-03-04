<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DevicePropsRepository;
use App\Entity\Attr;
use App\Entity\Prop;

#[ORM\Entity(repositoryClass: DevicePropsRepository::class)]
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

    private ?Attr $attr = null;

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

    public function getAttr(): ?Attr
    {
        return $this->attr;
    }

    public function setAttr(?Attr $attr): static
    {
        $this->attr = $attr;
        return $this;
    }
}
