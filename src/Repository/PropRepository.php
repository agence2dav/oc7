<?php

namespace App\Repository;

use App\Entity\Prop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PropRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prop::class);
    }

    public function saveProp(Prop $device): void
    {
        $this->getEntityManager()->persist($device);
        $this->getEntityManager()->flush();
    }

}
