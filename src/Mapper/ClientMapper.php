<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\ClientModel;
use Doctrine\Common\Collections\Collection;

class ClientMapper
{
    public function __construct(
    ) {
    }

    public function entityToModel(object $clientEntity): ClientModel
    {
        $clientModel = new ClientModel();
        $clientModel->setId($clientEntity->getId());
        $clientModel->setCorporation($clientEntity->getCorporation());
        $clientModel->setEmail($clientEntity->getEmail());
        //$clientModel->setLinks($clientEntity->getId());
        return $clientModel;
    }

    public function entitiesToModels(Collection|array $clientEntities): array
    {
        $clientModels = [];
        foreach ($clientEntities as $clientEntity) {
            $clientModels[] = $this->entityToModel($clientEntity);
        }
        return $clientModels;
    }

}
