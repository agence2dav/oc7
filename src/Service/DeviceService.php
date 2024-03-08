<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DevicePropRepository;
use App\Repository\DeviceRepository;
use App\Mapper\DeviceMapper;
use App\Model\DeviceModel;
use App\Entity\Device;
use App\Entity\User;

class DeviceService
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly DevicePropRepository $devicePropsRepository,
        private readonly DeviceRepository $deviceRepository,
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

    public function getModelByName(string $name): DeviceModel
    {
        $deviceEntity = $this->deviceRepository->findOneByName($name);
        return $this->deviceMapper->EntityToModel($deviceEntity);
    }

    public function getDevices(): array
    {
        $deviceEntities = $this->deviceRepository->getDevices();
        return $this->deviceMapper->EntitiesToModels($deviceEntities);
    }

    public function getAllDevices(): array
    {
        $deviceEntities = $this->deviceRepository->findAll();
        return $this->deviceMapper->EntitiesToModels($deviceEntities);
    }

    public function getFirstId(): Device|null
    {
        return $this->deviceRepository->findFirstDevice();
    }

    public function getLastsDevices(): array
    {
        $deviceEntities = $this->deviceRepository->findLastsByStatus();
        return $this->deviceMapper->EntitiesToModels($deviceEntities);
    }

    public function saveDevice(
        Device $device,
    ): void {
        if (!$device->getId()) {
            $device->setStatus(1);
        }
        $device->setUrl($device->getUrl());
        $this->deviceRepository->saveDevice($device);
    }

    public function deleteProp(Device $device, int $propId): void
    {
        $deviceProps = $device->getDeviceProps();
        foreach ($deviceProps as $deviceProp) {
            if ($deviceProp->getProp()->getId() == $propId) {
                $deviceProp = $this->devicePropsRepository->findOneById($deviceProp->getId());
                $this->devicePropsRepository->delete($deviceProp);
            }
        }
    }

    public function updateStatus(int $id): void
    {
        $device = $this->deviceRepository->findOneById($id);
        $status = $device->getStatus();
        $status = $status == 1 ? 0 : 1;
        $device->setStatus($status);
        $this->deviceRepository->saveDevice($device);
    }

}
