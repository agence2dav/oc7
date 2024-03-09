<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Model\ClientApiModel;
use App\Mapper\UserApiMapper;
use Doctrine\Common\Collections\Collection;

class ClientApiMapper
{
    public function __construct(
        private UserApiMapper $userApiMapper,
    ) {
    }

    public function EntityToModel(object $clientEntity): ClientApiModel
    {
        $clientApiModel = new ClientApiModel();
        $clientApiModel->setUrl($clientEntity->getId());
        return $clientApiModel;
    }

    public function EntitiesToModels(array $clientEntities): array
    {
        $clientApiModels = [];
        foreach ($clientEntities as $clientEntity) {
            $clientApiModels[] = $this->EntityToModel($clientEntity);
        }
        return $clientApiModels;
    }

}
