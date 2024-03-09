<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Mapper\PropMapper;
use App\Model\DevicePropModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class DevicePropMapper
{
    public function __construct(
        private readonly PropMapper $propMapper,
        private readonly AttrMapper $attrMapper,
    ) {

    }

    public function EntityToModel(object $deviceProps): DevicePropModel
    {
        $devicePropsModel = new DevicePropModel();
        //$devicePropsModel->setId($deviceProps->getId());
        //$devicePropsModel->setProp($deviceProps->getProp());
        //$devicePropsModel->setProp($this->propMapper->EntityToModel($deviceProps->getProp()));
        //$devicePropsModel->setAttr($deviceProps->getProp()->getAttr());
        //$devicePropsModel->setDevice($deviceProps->getDevice());
        $devicePropsModel->setPropName($deviceProps->getProp()->getName());
        //$devicePropsModel->setAttrName($deviceProps->getProp()->getAttr()->getName());
        $devicePropsModel->setAttrUrl($deviceProps->getProp()->getAttr()->getid());
        //$devicePropsModel->setPropUrl($deviceProps->getProp()->getid());
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
        $deviceModels = new ArrayCollection;
        foreach ($deviceCollection as $deviceEntity) {
            $deviceModels[] = $this->EntityToModel($deviceEntity);
        }
        return $deviceModels;
    }

}
