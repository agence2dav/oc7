<?php

declare(strict_types=1);

namespace App\Mapper;

use Doctrine\Common\Collections\Collection;
use App\Model\DevicePropsModel;

class DevicePropsMapper
{

    public function EntityToModel(object $deviceProps): DevicePropsModel
    {
        $devicePropsModel = new DevicePropsModel();
        $devicePropsModel->setId($deviceProps->getId());
        $devicePropsModel->setProp($deviceProps->getProp());
        $devicePropsModel->setAttr($deviceProps->getProp()->getAttr());
        $devicePropsModel->setDevice($deviceProps->getDevice());
        return $devicePropsModel;
    }

    public function EntitiesToModels(Collection $devicePropsEntities): array
    {
        $devicePropsModels = [];
        foreach ($devicePropsEntities as $deviceProps) {
            $devicePropsModels[] = $this->EntityToModel($deviceProps);
        }
        return $devicePropsModels;
    }

    public function EntitiesArrayToModels(array $devicePropsEntities): array
    {
        $devicePropsModels = [];
        foreach ($devicePropsEntities as $deviceProps) {
            $devicePropsModels[] = $this->EntityToModel($deviceProps);
        }
        return $devicePropsModels;
    }

}
