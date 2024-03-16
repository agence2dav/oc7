<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;

class ClientService
{

    public function __construct(
        private ClientRepository $clientRepo,
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

}
