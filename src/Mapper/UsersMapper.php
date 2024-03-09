<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\UsersModel;

class UsersMapper
{

    public function EntityToApiModel(object $clientEntity): UsersModel
    {
        $usersModel = new UsersModel();
        $usersModel->setUserUrl($clientEntity->getId());
        return $usersModel;
    }

    public function EntitiesToModels(array $clientEntities): array
    {
        $userModels = [];
        foreach ($clientEntities as $clientEntity) {
            $userModels[] = $this->EntityToApiModel($clientEntity);
        }
        return $userModels;
    }

}
