<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\DeviceProp;
use App\Entity\Device;
use App\Entity\Attr;

class PropModel
{
    private ?int $id = null;
    private ?string $name = null;
    private ?DeviceProp $deviceProps = null;
    private ?Device $device = null;
    private ?Attr $attr = null;

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

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
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

    public function getAttr(): ?Attr
    {
        return $this->attr;
    }

    public function setAttr(?Attr $attr): static
    {
        $this->attr = $attr;
        return $this;
    }

    public function getDeviceProps(): ?DeviceProp
    {
        return $this->deviceProps;
    }

    public function setDeviceProps(?DeviceProp $deviceProps): static
    {
        $this->deviceProps = $deviceProps;
        return $this;
    }

}
