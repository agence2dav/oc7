<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Attr;
use App\Entity\Prop;
use App\Entity\Device;
use App\Entity\DeviceProps;

class DevicePropsModel
{
    private ?int $id = null;
    private ?Prop $prop = null;
    private ?Attr $attr = null;
    private ?Device $device = null;
    private ?DeviceProps $deviceProps = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
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

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): static
    {
        $this->device = $device;
        return $this;
    }

    public function getDeviceProps(): ?DeviceProps
    {
        return $this->deviceProps;
    }

    public function setDeviceProps(?DeviceProps $deviceProps): static
    {
        $this->deviceProps = $deviceProps;
        return $this;
    }

}
