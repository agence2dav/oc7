<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\Device;
use App\Model\DeviceModel;
use App\Mapper\DeviceMapper;
use App\Model\DeviceApiModel;
use App\Mapper\DeviceApiMapper;
use App\Repository\DeviceRepository;
use App\Repository\DevicePropRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeviceService
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly DevicePropRepository $devicePropsRepository,
        private readonly DeviceRepository $deviceRepository,
        private readonly DeviceApiMapper $deviceApiMapper,
        private readonly DeviceMapper $deviceMapper,
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

    public function getModelById(int $id): DeviceModel
    {
        $deviceEntity = $this->deviceRepository->findOneById($id);
        return $this->deviceMapper->EntityToModel($deviceEntity);
    }

    public function getApiModelById(int $id): DeviceApiModel
    {
        $deviceEntity = $this->deviceRepository->findOneById($id);
        return $this->deviceApiMapper->EntityToModel($deviceEntity);
    }

    public function getModelByName(string $name): DeviceModel
    {
        $deviceEntity = $this->deviceRepository->findOneByName($name);
        return $this->deviceMapper->EntityToModel($deviceEntity);
    }

    public function getDevices(): array
    {
        $deviceEntities = $this->deviceRepository->getDevices();
        return $this->deviceApiMapper->EntitiesToModels($deviceEntities);
    }

    public function getAllDevices(): array
    {
        $deviceEntities = $this->deviceRepository->findAll();
        return $this->deviceApiMapper->EntitiesToModels($deviceEntities);
    }

    public function getFirstId(): Device|null
    {
        return $this->deviceRepository->findFirstDevice();
    }

}
