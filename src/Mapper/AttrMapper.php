<?php

declare(strict_types=1);

namespace App\Mapper;

use Doctrine\Common\Collections\Collection;
use App\Model\AttrModel;

class AttrMapper
{
    public function EntityToModel(object $attrEntity): AttrModel
    {
        $attrModel = new AttrModel();
        $attrModel->setName($attrEntity->getName());
        return $attrModel;
    }

    public function EntitiesToModels(array $attrEntities): array
    {
        $attrModels = [];
        foreach ($attrEntities as $attrEntity) {
            $attrModels[] = $this->EntityToModel($attrEntity);
        }
        return $attrModels;
    }

}
