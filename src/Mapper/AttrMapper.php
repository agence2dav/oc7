<?php

declare(strict_types=1);

namespace App\Mapper;

use Doctrine\Common\Collections\Collection;
use App\Model\AttrModel;

class AttrMapper
{
    public function EntityToModel(object $catEntity): AttrModel
    {
        $catModel = new AttrModel();
        $catModel->setId($catEntity->getId());
        $catModel->setName($catEntity->getName());
        $catModel->setProps($catEntity->getProps());
        return $catModel;
    }

    public function EntitiesToModels(array $catEntities): array
    {
        $catModels = [];
        foreach ($catEntities as $catEntity) {
            $catModels[] = $this->EntityToModel($catEntity);
        }
        return $catModels;
    }

}
