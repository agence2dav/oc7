<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DevicePropsRepository;
use App\Repository\DeviceRepository;
use App\Mapper\DeviceMapper;
use App\Model\DeviceModel;
use App\Entity\Device;
use App\Entity\User;

class DeviceService
{

    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly DevicePropsRepository $devicePropsRepository,
        private readonly DeviceRepository $deviceRepository,
        private readonly DeviceMapper $deviceMapper,
    ) {

    }
    public const PAGINATOR_PER_PAGE = 10;

    public function getAll(): Device|array
    {
        return $this->deviceRepository->findAll();
    }

    public function getById(int $id): DeviceModel
    {
        $deviceEntity = $this->deviceRepository->findOneById($id);
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

    public function getLastsDevices(): array
    {
        $deviceEntities = $this->deviceRepository->findLastsByStatus();
        return $this->deviceMapper->EntitiesToModels($deviceEntities);
    }

    public function saveDevice(
        Device $device,
        User $user,
        string $video = null,
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
