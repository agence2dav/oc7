<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Model\ClientDetailsModel;
use App\Model\ClientSummaryModel;
use App\Mapper\ClientDetailsMapper;
use App\Mapper\ClientSummaryMapper;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;

class ClientService
{

    public function __construct(
        private ClientRepository $clientRepo,
        private ClientDetailsMapper $clientDetailsMapper,
        private ClientSummaryMapper $clientSummaryMapper,
    ) {

    }

    public function getById(int $id): Client|null
    {
        return $this->clientRepo->findOneById($id);
    }

    public function getAll(): array|null
    {
        return $this->clientRepo->findAll();
    }

    public function getClientById(int $id): Client|null
    {
        return $this->clientRepo->findOneById($id);
    }

    public function getUsersByClientId(int $id): Collection|array
    {
        return $this->clientRepo->findByClientId($id);
    }

    public function getClientsList(): Collection|array
    {
        return $this->clientSummaryMapper->entitiesToModels($this->getAll());
    }

    public function getClientSummary(int $id): ClientSummaryModel|null
    {
        return $this->clientSummaryMapper->entityToModel($this->getClientById($id));
    }

    public function getClientDetails(Client $client): ClientDetailsModel|null
    {
        return $this->clientDetailsMapper->entityToModel($client);
    }

}
