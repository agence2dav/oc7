<?php

declare(strict_types=1);

namespace App\Mapper;

use Doctrine\Common\Collections\Collection;
use App\Model\AttrModel;

class AttrMapper
{
    public function entityToModel(object $attrEntity): AttrModel
    {
        $attrModel = new AttrModel();
        $attrModel->setId($attrEntity->getId());
        $attrModel->setName($attrEntity->getName());
        $attrModel->setLinks();
        return $attrModel;
    }

    public function entitiesToModels(array $attrEntities): array
    {
        $attrModels = [];
        foreach ($attrEntities as $attrEntity) {
            $attrModels[] = $this->entityToModel($attrEntity);
        }
        return $attrModels;
    }

}
