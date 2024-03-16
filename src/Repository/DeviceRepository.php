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

    public function findAll(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllByPage(int $page, int $limit): array
    {
        return $this->createQueryBuilder('t')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findAllId(): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('t.id')
            ->getQuery()
            ->getResult();
    }

    public function countAll(): int
    {
        return $this->createQueryBuilder('t')
            ->addSelect('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
