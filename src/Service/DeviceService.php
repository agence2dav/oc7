<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\Device;
use App\Model\DevicesModel;
use App\Mapper\DevicesMapper;
use App\Model\DeviceModel;
use App\Mapper\DeviceMapper;
use App\Repository\DeviceRepository;
use App\Repository\DevicePropRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeviceService
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly DevicePropRepository $devicePropsRepository,
        private readonly DeviceRepository $deviceRepository,
        private readonly DeviceMapper $deviceMapper,
        private readonly DevicesMapper $devicesMapper,
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
        //return $this->deviceRepository->findDevice($id);
        return $this->deviceRepository->findOneById($id);
    }

    public function getDevices(): array
    {
        $deviceEntities = $this->deviceRepository->findAll();
        return $this->devicesMapper->EntitiesToModels($deviceEntities);
    }

    public function getDevice(int $id): DeviceModel
    {
        $deviceEntity = $this->deviceRepository->findOneById($id);
        return $this->deviceMapper->EntityToModel($deviceEntity);
    }

    public function getModelByName(string $name): DevicesModel
    {
        $deviceEntity = $this->deviceRepository->findOneByName($name);
        return $this->devicesMapper->EntityToModel($deviceEntity);
    }

}
