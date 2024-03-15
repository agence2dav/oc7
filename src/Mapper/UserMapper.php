<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\UserModel;
use Doctrine\Common\Collections\Collection;

class UserMapper
{
    public function entityToModel(object $clientEntity): UserModel
    {
        $userModel = new UserModel();
        $userModel->setId($clientEntity->getId());
        $userModel->setUserName($clientEntity->getUserName());
        return $userModel;
    }

    public function entitiesToModels(Collection|array $clientEntities): array
    {
        $userModels = [];
        foreach ($clientEntities as $clientEntity) {
            $userModels[] = $this->entityToModel($clientEntity);
        }
        return $userModels;
    }

}
