<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Device;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

class DeviceRepository extends ServiceEntityRepository
{

    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Device::class);
    }

    public function findDevice(int $id): Device
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :id')
            ->setParameter('id', $id)
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDevices(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = 1')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countByStatus(): int
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.status = 1')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function findLastsByStatus(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = 1')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function saveDevice(Device $device): void
    {
        $this->getEntityManager()->persist($device);
        $this->getEntityManager()->flush();
    }

}
