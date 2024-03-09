<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;

class DevicesModel
{
    private string $deviceUrl;

    public function getDeviceUrl(): ?string
    {
        return $this->deviceUrl;
    }

    public function setDeviceUrl(int $id): static
    {
        $this->deviceUrl = '/api/device/' . $id;
        return $this;
    }

}
