<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\DevicePropModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class DevicePropMapper
{
    public function __construct(
    ) {
    }

    public function EntityToModel(object $deviceProps): DevicePropModel
    {
        $devicePropsModel = new DevicePropModel();
        $devicePropsModel->setPropUrl($deviceProps->getProp()->getid());
        return $devicePropsModel;
    }

    public function EntitiesToModels(array $devicePropsEntities): array
    {
        $devicePropsModels = [];
        foreach ($devicePropsEntities as $deviceProps) {
            $devicePropsModels[] = $this->EntityToModel($deviceProps);
        }
        return $devicePropsModels;
    }

    public function CollectionToModels(Collection $deviceCollection): Collection
    {
        $devicePropsModels = new ArrayCollection;
        foreach ($deviceCollection as $deviceEntity) {
            $devicePropsModels[] = $this->EntityToModel($deviceEntity);
        }
        return $devicePropsModels;
    }

}
