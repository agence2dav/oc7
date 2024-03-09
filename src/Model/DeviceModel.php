<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;

class DeviceModel
{
    private Collection $deviceProps;

    public function getDeviceProps(): Collection
    {
        return $this->deviceProps;
    }

    public function setDeviceProps(Collection $deviceProps): static
    {
        $this->deviceProps = $deviceProps;
        return $this;
    }
}
