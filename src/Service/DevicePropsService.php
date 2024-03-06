<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DeviceRepository;
use App\Repository\PropRepository;
use App\Repository\AttrRepository;
use App\Repository\DevicePropsRepository;
use App\Mapper\DevicePropsMapper;
use App\Entity\DeviceProps;
use App\Entity\Device;

class DevicePropsService
{

    public function __construct(
        private DeviceRepository $DeviceRepo,
        private PropRepository $propRepo,
        private AttrRepository $catRepo,
        private DevicePropsRepository $devicePropsRepo,
        private DevicePropsMapper $devicePropsMapper,
        private EntityManagerInterface $manager
    ) {

    }

    public function saveDeviceProp(
        Device $device,
        string $propId,
    ): void {
        $deviceProps = new DeviceProps();
        $prop = $this->propRepo->findOneBy(['id' => $propId]);
        if ($prop) {
            $attr = $prop->getAttr();
            $deviceProps->setDevice($device);
            $deviceProps->setAttr($attr);
            $deviceProps->setProp($prop);
            $this->devicePropsRepo->saveDeviceProps($deviceProps);
        }
    }

    public function getDevicesByProp(int $id): Device|array
    {
        $devicePropsModel = $this->devicePropsRepo->findBy(['prop' => $id], ['id' => 'ASC']);
        return $this->devicePropsMapper->EntitiesArrayToModels($devicePropsModel);
    }

}
