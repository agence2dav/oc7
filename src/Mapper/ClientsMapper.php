<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\ClientsModel;

class ClientsMapper
{
    public function __construct(
        private UsersMapper $usersMapper,
    ) {
    }

    public function EntityToModel(object $clientEntity): ClientsModel
    {
        $clientsModel = new ClientsModel();
        $clientsModel->setLinks($clientEntity->getId());
        return $clientsModel;
    }

    public function EntitiesToModels(array $clientEntities): array
    {
        $clientsModels = [];
        foreach ($clientEntities as $clientsEntity) {
            $clientsModels[] = $this->EntityToModel($clientsEntity);
        }
        return $clientsModels;
    }

}
