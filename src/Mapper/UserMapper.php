<?php

declare(strict_types=1);

namespace App\Mapper;

use Doctrine\Common\Collections\Collection;
use App\Model\UserModel;

class UserMapper
{
    public function EntityToModel(object $clientEntity): UserModel
    {
        $clientModel = new UserModel();
        $clientModel->setId($clientEntity->getId());
        $clientModel->setUserName($clientEntity->getUserName());
        $clientModel->setEmail($clientEntity->getEmail());
        //$clientModel->setClient($clientEntity->getClient());
        return $clientModel;
    }

    public function EntitiesToModels(array $clientEntities): array
    {
        $clientModels = [];
        foreach ($clientEntities as $clientEntity) {
            $clientModels[] = $this->EntityToModel($clientEntity);
        }
        return $clientModels;
    }

}
