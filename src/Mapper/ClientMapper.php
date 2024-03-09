<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\ClientModel;
use App\Mapper\UsersMapper;

class ClientMapper
{
    public function __construct(
        private UsersMapper $usersMapper,
    ) {
    }

    public function EntityToModel(object $clientEntity): ClientModel
    {
        $clientModel = new ClientModel();
        $clientModel->setId($clientEntity->getId());
        $clientModel->setClientName($clientEntity->getClientName());
        $clientModel->setEmail($clientEntity->getEmail());
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
