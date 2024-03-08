<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DeviceRepository;
use App\Repository\PropRepository;
use App\Repository\AttrRepository;
use App\Repository\DevicePropRepository;
use App\Mapper\DevicePropMapper;
use App\Entity\DeviceProp;
use App\Entity\Device;

class DevicePropService
{

    public function __construct(
        private DeviceRepository $DeviceRepo,
        private PropRepository $propRepo,
        private AttrRepository $catRepo,
        private DevicePropRepository $devicePropsRepo,
        private DevicePropMapper $devicePropsMapper,
        private EntityManagerInterface $manager
    ) {

    }

    public function saveDeviceProp(
        Device $device,
        string $propId,
    ): void {
        $deviceProps = new DeviceProp();
        $prop = $this->propRepo->findOneBy(['id' => $propId]);
        if ($prop) {
            $attr = $prop->getAttr();
            $deviceProps->setDevice($device);
            //$deviceProps->setAttr($attr);
            $deviceProps->setProp($prop);
            $this->devicePropsRepo->saveDeviceProp($deviceProps);
        }
    }

    public function getDevicesByProp(int $id): Device|array
    {
        $devicePropsModel = $this->devicePropsRepo->findBy(['prop' => $id], ['id' => 'ASC']);
        return $this->devicePropsMapper->EntitiesArrayToModels($devicePropsModel);
    }

}
