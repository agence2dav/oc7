<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\UserDetailsModel;
use Doctrine\Common\Collections\Collection;

class UserDetailsMapper
{

    public function entityToModel(object $clientEntity): UserDetailsModel
    {
        $userModel = new UserDetailsModel();
        $userModel->setId($clientEntity->getId());
        $userModel->setUserName($clientEntity->getUserName());
        $userModel->setEmail($clientEntity->getEmail());
        $userModel->setStatus($clientEntity->getStatus());
        $userModel->setCreatedAt($clientEntity->getCreatedAt());
        $userModel->setUserUrl($clientEntity->getClient()->getId());
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
