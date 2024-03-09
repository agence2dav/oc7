<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Mapper\PropMapper;
use App\Model\DevicePropApiModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class DevicePropApiMapper
{
    public function __construct(
        private readonly PropMapper $propMapper,
        private readonly AttrMapper $attrMapper,
    ) {

    }

    public function EntityToModel(object $deviceProps): DevicePropApiModel
    {
        $devicePropApiModel = new DevicePropApiModel();
        $devicePropApiModel->setPropUrl($deviceProps->getProp()->getid());
        return $devicePropApiModel;
    }

    public function EntitiesToModels(array $devicePropsEntities): array
    {
        $devicePropApiModels = [];
        foreach ($devicePropsEntities as $deviceProps) {
            $devicePropApiModels[] = $this->EntityToModel($deviceProps);
        }
        return $devicePropApiModels;
    }

    public function CollectionToModels(Collection $deviceCollection): Collection
    {
        $deviceModels = new ArrayCollection;
        foreach ($deviceCollection as $deviceEntity) {
            $deviceModels[] = $this->EntityToModel($deviceEntity);
        }
        return $deviceModels;
    }

}
