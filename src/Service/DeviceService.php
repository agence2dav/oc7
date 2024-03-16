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

    public function getAllId(): array
    {
        return $this->deviceRepository->findAllId();
    }

    public function getAllByPage(int $page, int $limit): array
    {
        return $this->deviceRepository->findAllByPage($page, $limit);
    }

    public function getById(int $id): Device
    {
        return $this->deviceRepository->findOneById($id);
    }


    public function getNumberOfDevices(): int
    {
        return $this->deviceRepository->countAll();
    }
}
