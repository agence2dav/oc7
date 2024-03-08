<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\DeviceProp;

class DevicePropRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceProp::class);
    }

    public function saveDeviceProps(DeviceProp $deviceProp): void
    {
        $this->getEntityManager()->persist($deviceProp);
        $this->getEntityManager()->flush();
    }

    public function delete(DeviceProp $deviceProp): void
    {
        $this->getEntityManager()->remove($deviceProp);
        $this->getEntityManager()->flush();
    }

}
