<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\PropModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class PropMapper
{
    public function entityToModel(object $propEntity): PropModel
    {
        $propModel = new PropModel();
        $propModel->setName($propEntity->getName());
        $propModel->setAttrUrl($propEntity->getAttr()->getId());
        return $propModel;
    }

    public function entitiesToModels(array $propEntities): array
    {
        $propModels = [];
        foreach ($propEntities as $propEntity) {
            $propModels[] = $this->entityToModel($propEntity);
        }
        return $propModels;
    }

    public function CollectionToModels(Collection $propCollection): Collection
    {
        $propModels = new ArrayCollection;
        foreach ($propCollection as $deviceEntity) {
            $propModels[] = $this->entityToModel($deviceEntity);
        }
        return $propModels;
    }

}
