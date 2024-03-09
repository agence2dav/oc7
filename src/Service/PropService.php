<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Device;
use App\Mapper\PropMapper;
use App\Model\PropModel;
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

    public function getAll(): Device|array
    {
        return $this->propRepo->findAll();
    }

    public function getProps(int $id): PropModel
    {
        $deviceEntity = $this->propRepo->findOneById($id);
        return $this->propMapper->EntityToModel($deviceEntity);
    }

}
