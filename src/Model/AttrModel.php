<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;
use App\Entity\DeviceProp;
use App\Entity\Device;

class AttrModel
{
    private ?int $id = null;
    private ?string $name = null;
    private ?DeviceProp $deviceProps = null;
    private ?Device $device = null;
    private Collection $props;

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

    public function getProps(): Collection
    {
        return $this->props;
    }

    //added
    public function setProps(Collection $props): AttrModel
    {
        $this->props = $props;
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
