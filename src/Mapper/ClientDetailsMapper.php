<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Mapper\UserSummaryMapper;
use App\Model\ClientDetailsModel;
use Doctrine\Common\Collections\Collection;

class ClientDetailsMapper
{
    public function __construct(
        private UserSummaryMapper $userSummaryMapper,
    ) {
    }

    public function entityToModel(object $clientEntity): ClientDetailsModel
    {
        $clientModel = new ClientDetailsModel();
        $clientModel->setId($clientEntity->getId());
        $clientModel->setCorporation($clientEntity->getCorporation());
        $clientModel->setEmail($clientEntity->getEmail());
        $clientModel->setClientUsers($this->userSummaryMapper->entitiesToModels($clientEntity->getUsers()));
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
