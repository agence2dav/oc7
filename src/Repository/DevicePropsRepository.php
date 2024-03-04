<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\DeviceProps;

class DevicePropsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceProps::class);
    }

    public function saveDeviceProps(DeviceProps $deviceProp): void
    {
        $this->getEntityManager()->persist($deviceProp);
        $this->getEntityManager()->flush();
    }

    public function delete(DeviceProps $deviceProp): void
    {
        $this->getEntityManager()->remove($deviceProp);
        $this->getEntityManager()->flush();
    }

}
