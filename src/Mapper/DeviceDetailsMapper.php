<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Model\DeviceDetailsModel;
use App\Mapper\DevicePropMapper;

class DeviceDetailsMapper
{
    public function __construct(
        private DevicePropMapper $devicePropMapper,
    ) {
    }

    public function entityToModel(Device $deviceEntity): DeviceDetailsModel
    {
        $deviceModel = new DeviceDetailsModel();
        $deviceModel->setId($deviceEntity->getId());
        $deviceModel->setName($deviceEntity->getName());
        $deviceModel->setUrl($deviceEntity->getUrl());
        $deviceModel->setImage($deviceEntity->getImage());
        $deviceModel->setStatus($deviceEntity->getStatus());
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
