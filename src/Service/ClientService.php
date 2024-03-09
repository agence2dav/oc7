<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Model\ClientModel;
use App\Model\ClientsModel;
use App\Mapper\ClientMapper;
use App\Mapper\ClientsMapper;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;

class ClientService
{

    public function __construct(
        private ClientRepository $clientRepo,
        private ClientMapper $clientMapper,
        private ClientsMapper $clientsMapper,
    ) {

    }

    public function getClients(): Collection|array
    {
        $clientsModel = $this->clientRepo->findAll();
        return $this->clientsMapper->EntitiesToModels($clientsModel);
    }

    public function getClient(int $id): ClientModel|null
    {
        $clientModel = $this->clientRepo->findOneById($id);
        return $this->clientMapper->EntityToModel($clientModel);
    }

    public function getFirstId(): int|null
    {
        return $this->clientRepo->findFirstClientId();
    }

}
