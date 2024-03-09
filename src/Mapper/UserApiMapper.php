<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\UserApiModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class UserApiMapper
{

    public function EntityToApiModel(object $clientEntity): UserApiModel
    {
        $userApiModel = new UserApiModel();
        $userApiModel->setUrl($clientEntity->getId());
        return $userApiModel;
    }

    public function EntitiesToModels(array $clientEntities): array
    {
        $userModels = [];
        foreach ($clientEntities as $clientEntity) {
            $userModels[] = $this->EntityToApiModel($clientEntity);
        }
        return $userModels;
    }

    public function CollectionToModels(Collection $clientCollection): Collection
    {
        $userModels = new ArrayCollection;
        foreach ($clientCollection as $clientEntity) {
            $userModels[] = $this->EntityToApiModel($clientEntity);
        }
        return $userModels;
    }

}
