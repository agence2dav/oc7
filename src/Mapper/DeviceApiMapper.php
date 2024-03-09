<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Mapper\PropMapper;
use App\Model\DeviceModel;
use App\Model\DeviceApiModel;
use App\Mapper\DevicePropMapper;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class DeviceApiMapper
{
    public function __construct(
        private DevicePropMapper $devicePropMapper,
        private DevicePropApiMapper $devicePropApiMapper,
        //private PropMapper $propMapper,
    ) {
    }

    public function EntityToModel(Device $deviceEntity): DeviceApiModel
    {
        $deviceModel = new DeviceApiModel();
        $deviceModel->setdeviceProps($this->devicePropApiMapper->CollectionToModels($deviceEntity->getdeviceProps()));

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
