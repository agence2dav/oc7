<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Prop;

class DevicePropModel
{
    private int $deviceId;
    private array $properties;

    public function getDeviceId(): int
    {
        return $this->deviceId;
    }

    public function setDeviceId(int $deviceId): static
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    /* 
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperties(Prop $prop): static
    {
        $this->properties = [
            'property' => $prop->getName(),
            'propertyId' => $prop->getId(),
            'attribut' => $prop->getAttr()->getName(),
            'attributId' => $prop->getAttr()->getId(),
            '_links' => [
                'self' => (string) '/api/devices/property/' . $prop->getId(),
                'href' => (string) '/api/devices/property/attribut/' . $prop->getAttr()->getId()
            ]
        ];
        return $this;
    }*/

}
