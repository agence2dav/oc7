<?php

declare(strict_types=1);

namespace App\Mapper;

use Doctrine\Common\Collections\Collection;
use App\Model\ClientModel;

class ClientMapper
{
    public function __construct(
        private UserMapper $userMapper,
    ) {
    }

    public function EntityToModel(object $clientEntity): ClientModel
    {
        $clientModel = new ClientModel();
        $clientModel->setId($clientEntity->getId());
        $clientModel->setClientName($clientEntity->getClientName());
        $clientModel->setEmail($clientEntity->getEmail());
        $clientModel->setUsers($clientEntity->getUsers());
        //$clientModel->setUsers($this->userMapper->EntitiesToModels($clientEntity->getUsers()));
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
