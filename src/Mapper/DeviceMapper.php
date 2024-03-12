<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Model\DeviceModel;
use App\Mapper\DevicePropMapper;

class DeviceMapper
{
    public function __construct(
        private DevicePropMapper $devicePropMapper,
    ) {
    }

    public function entityToModel(Device $deviceEntity): DeviceModel
    {
        $deviceModel = new DeviceModel();
        $deviceModel->setdeviceProps($this->devicePropMapper->CollectionToModels($deviceEntity->getdeviceProps()));
        return $deviceModel;
    }

    public function entitiesToModels(array $deviceEntities): array
    {
        $deviceModels = [];
        foreach ($deviceEntities as $deviceEntity) {
            $deviceModels[] = $this->entityToModel($deviceEntity);
        }
        return $deviceModels;
    }

}
