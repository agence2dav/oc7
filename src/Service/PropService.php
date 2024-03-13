<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Prop;
use App\Entity\Device;
use App\Model\PropModel;
use App\Mapper\PropMapper;
use App\Repository\PropRepository;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;

class PropService
{

    public function __construct(
        private DeviceRepository $DeviceRepo,
        private PropRepository $propRepo,
        private PropMapper $propMapper,
        private EntityManagerInterface $manager
    ) {

    }

    public function getAll(): Prop|array
    {
        return $this->propRepo->findAll();
    }

    public function getProp(int $id): Prop
    {
        return $this->propRepo->findOneById($id);
    }

    public function getProps(int $id): PropModel
    {
        return $this->propMapper->entityToModel($this->getProp($id));
    }

}
