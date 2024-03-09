<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\DeviceProp;
use App\Entity\Device;
use App\Entity\Attr;

class PropApiModel
{
    private ?string $name = null;
    private ?string $attrUrl = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getAttrUrl(): ?string
    {
        return $this->attrUrl;
    }

    public function setAttrUrl(int $id): static
    {
        $this->attrUrl = '/api/attr/' . $id;
        return $this;
    }

}
