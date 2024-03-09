<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Model\DeviceModel;
use App\Mapper\DevicePropMapper;

class DeviceMapper
{
    public function __construct(
        private DevicePropMapper $devicePropsMapper,
    ) {
    }

    public function EntityToModel(Device $deviceEntity): DeviceModel
    {
        $deviceModel = new DeviceModel();
        $deviceModel->setdeviceProps($this->devicePropsMapper->CollectionToModels($deviceEntity->getdeviceProps()));

        return $deviceModel;
    }

    public function EntitiesToModels(array $deviceEntities): array
    {
        $deviceModels = [];
        foreach ($deviceEntities as $deviceEntity) {
            $deviceModels[] = $this->EntityToModel($deviceEntity);
        }
        return $deviceModels;
    }

}
