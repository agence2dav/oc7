<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use App\Repository\DeviceRepository;
use App\Repository\ClientRepository;
use App\Mapper\ClientMapper;
use App\Entity\Device;

class ClientService
{

    public function __construct(
        private DeviceRepository $deviceRepo,
        private ClientRepository $clientRepo,
        private ClientMapper $clientMapper,
        private EntityManagerInterface $manager
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

}
