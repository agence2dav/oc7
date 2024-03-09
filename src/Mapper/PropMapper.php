<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\PropModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class PropMapper
{
    public function EntityToModel(object $propEntity): PropModel
    {
        $propModel = new PropModel();
        $propModel->setId($propEntity->getId());
        $propModel->setName($propEntity->getName());
        //$propModel->setDevice($propEntity->getDevice());
        $propModel->setAttr($propEntity->getAttr());
        return $propModel;
    }

    public function EntitiesToModels(array $propEntities): array
    {
        $propModels = [];
        foreach ($propEntities as $propEntity) {
            $propModels[] = $this->EntityToModel($propEntity);
        }
        return $propModels;
    }

    public function CollectionToModels(Collection $propCollection): Collection
    {
        $deviceModels = new ArrayCollection;
        foreach ($propCollection as $deviceEntity) {
            $deviceModels[] = $this->EntityToModel($deviceEntity);
        }
        return $deviceModels;
    }

}
