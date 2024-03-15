<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Device;
use App\Repository\DeviceRepository;

class DeviceService
{
    public function __construct(
        private readonly DeviceRepository $deviceRepository,
    ) {

    }

    public function getAll(): Device|array
    {
        return $this->deviceRepository->findAll();
    }

    public function getById(int $id): Device
    {
        return $this->deviceRepository->findOneById($id);
    }

}
