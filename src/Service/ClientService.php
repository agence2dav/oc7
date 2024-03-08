<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Mapper\ClientMapper;
use App\Repository\ClientRepository;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

class ClientService
{

    public function __construct(
        private DeviceRepository $deviceRepo,
        private ClientRepository $clientRepo,
        private ClientMapper $clientMapper,
    ) {

    }

    public function getAll(): Collection|array
    {
        $clientModel = $this->clientRepo->findAll();
        return $this->clientMapper->EntitiesToModels($clientModel);
    }

    public function getById(int $id): Collection|array
    {
        return $this->clientRepo->findById($id);
    }

    public function getModelById(int $id): Collection|array
    {
        $clientModel = $this->clientRepo->findById($id);
        return $this->clientMapper->EntitiesToModels($clientModel);
    }

    public function getFirstId(): int|null
    {
        return $this->clientRepo->findFirstClientId();
    }

}
