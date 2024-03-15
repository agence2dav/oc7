<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Device;
use App\Model\DeviceSummaryModel;

class DeviceSummaryMapper
{
    public function __construct(
    ) {
    }

    public function entityToModel(Device $deviceEntity): DeviceSummaryModel
    {
        $deviceModel = new DeviceSummaryModel();
        $deviceModel->setId($deviceEntity->getId());
        $deviceModel->setName($deviceEntity->getName());
        //$deviceModel->setLinks($deviceEntity->getId());
        return $deviceModel;
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
