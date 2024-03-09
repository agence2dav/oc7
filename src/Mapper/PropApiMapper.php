<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\PropApiModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class PropApiMapper
{
    public function EntityToModel(object $propEntity): PropApiModel
    {
        $propModel = new PropApiModel();
        $propModel->setName($propEntity->getName());
        $propModel->setAttrUrl($propEntity->getAttr()->getId());
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
