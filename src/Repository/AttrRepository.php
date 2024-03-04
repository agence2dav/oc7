<?php

namespace App\Repository;

use App\Entity\Attr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AttrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attr::class);
    }

    public function saveAttr(Attr $device): void
    {
        $this->getEntityManager()->persist($device);
        $this->getEntityManager()->flush();
    }

}
