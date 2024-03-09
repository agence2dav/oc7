<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findFirstUserId(): int
    {
        return $this->createQueryBuilder('t')
            ->select('t.id')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->setFirstResult(1)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

}
