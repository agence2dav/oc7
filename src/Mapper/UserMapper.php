<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\UserModel;

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

}
