<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Attr;
use App\Entity\Prop;
use App\Entity\Device;
use App\Entity\DeviceProp;

class DevicePropModel
{
    private string $propName;
    private string $attrUrl;

    public function getPropName(): string
    {
        return $this->propName;
    }

    public function setPropName(string $propName): static
    {
        $this->propName = $propName;
        return $this;
    }

    public function getAttrUrl(): string
    {
        return $this->attrUrl;
    }

    public function setAttrUrl(int $id): static
    {
        $this->attrUrl = '/api/attr/' . $id;
        return $this;
    }

}
