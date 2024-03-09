<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Mapper\PropMapper;
use App\Model\DeviceModel;
use App\Mapper\DevicePropMapper;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class DeviceMapper
{
    public function __construct(
        private DevicePropMapper $devicePropMapper,
        private DevicePropApiMapper $devicePropApiapper,
        //private PropMapper $propMapper,
    ) {
    }

    public function EntityToModel(Device $deviceEntity): DeviceModel
    {
        $deviceModel = new DeviceModel();
        $deviceModel->setId($deviceEntity->getId());
        $deviceModel->setName($deviceEntity->getName());
        $deviceModel->setUrl($deviceEntity->getUrl());
        $deviceModel->setImage($deviceEntity->getImage());
        $deviceModel->setStatus($deviceEntity->getStatus());
        //$deviceModel->setdeviceProp($deviceEntity->getdeviceProp());
        $deviceModel->setdeviceProps($this->devicePropMapper->CollectionToModels($deviceEntity->getdeviceProps()));
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

    public function CollectionToModels(array $deviceCollection): Collection
    {
        $deviceModels = new ArrayCollection;
        foreach ($deviceCollection as $deviceEntity) {
            $deviceModels[] = $this->EntityToModel($deviceEntity);
        }
        return $deviceModels;
    }

}
