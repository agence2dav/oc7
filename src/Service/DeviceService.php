<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Device;
use App\Model\DeviceSummaryModel;
use App\Model\DeviceDetailsModel;
use App\Mapper\DeviceSummaryMapper;
use App\Mapper\DeviceDetailsMapper;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeviceService
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly DeviceRepository $deviceRepository,
        private readonly DeviceSummaryMapper $deviceSummaryMapper,
        private readonly DeviceDetailsMapper $deviceDetailsMapper,
    ) {

    }

    public function getAll(): Device|array
    {
        return $this->deviceRepository->findAll();
    }

    public function getByName(string $name): Device
    {
        return $this->deviceRepository->findOneByName($name);
    }

    public function getById(int $id): Device
    {
        return $this->deviceRepository->findOneById($id);
    }

    //

    public function getDevices(): array
    {
        return $this->deviceSummaryMapper->entitiesToModels($this->getAll());
    }

    public function getDevice(int $id): DeviceDetailsModel
    {
        return $this->deviceDetailsMapper->entityToModel($this->getById($id));
    }

    public function getModelByName(string $name): DeviceSummaryModel
    {
        return $this->deviceSummaryMapper->entityToModel($this->getByName($name));
    }

}
