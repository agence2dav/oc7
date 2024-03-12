<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Model\DevicesModel;

class DevicesMapper
{
    public function __construct(
    ) {
    }

    public function entityToModel(Device $deviceEntity): DevicesModel
    {
        $devicesModel = new DevicesModel();
        $devicesModel->setDeviceUrl($deviceEntity->getId());
        return $devicesModel;
    }

    public function entitiesToModels(array $deviceEntities): array
    {
        $devicesModels = [];
        foreach ($deviceEntities as $deviceEntity) {
            $devicesModels[] = $this->entityToModel($deviceEntity);
        }
        return $devicesModels;
    }

}
