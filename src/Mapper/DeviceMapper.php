<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Mapper\PropMapper;
use App\Model\DeviceModel;
use App\Mapper\MediaMapper;
use App\Mapper\CommentMapper;
use App\Mapper\DevicePropsMapper;
use Doctrine\Common\Collections\Collection;

class DeviceMapper
{
    public function __construct(
        private DevicePropsMapper $devicePropsMapper,
        private PropMapper $propMapper,
    ) {
    }

    public function EntityToModel(Device $deviceEntity): DeviceModel
    {
        $deviceModel = new DeviceModel();
        $deviceModel->setId($deviceEntity->getId());
        $deviceModel->setPhone($deviceEntity->getPhone());
        $deviceModel->setUrl($deviceEntity->getUrl());
        $deviceModel->setImage($deviceEntity->getImage());
        $deviceModel->setStatus($deviceEntity->getStatus());
        $deviceModel->setDeviceProps($this->devicePropsMapper->EntitiesToModels($deviceEntity->getDeviceProps()));
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
