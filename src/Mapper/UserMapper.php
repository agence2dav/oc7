<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\UserModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class UserMapper
{
    public function EntityToModel(object $clientEntity): UserModel
    {
        $userModel = new UserModel();
        $userModel->setId($clientEntity->getId());
        $userModel->setUserName($clientEntity->getUserName());
        $userModel->setEmail($clientEntity->getEmail());
        $userModel->setStatus($clientEntity->getStatus());
        $userModel->setCreatedAt($clientEntity->getCreatedAt());
        //$userModel->setClient($clientEntity->getClient());
        return $userModel;
    }

    public function EntitiesToModels(array $clientEntities): array
    {
        $userModels = [];
        foreach ($clientEntities as $clientEntity) {
            $userModels[] = $this->EntityToModel($clientEntity);
        }
        return $userModels;
    }

    public function CollectionToModels(Collection $clientCollection): Collection
    {
        $userModels = new ArrayCollection;
        foreach ($clientCollection as $clientEntity) {
            $userModels[] = $this->EntityToModel($clientEntity);
        }
        return $userModels;
    }

}
