<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DeviceRepository;
use App\Repository\PropRepository;
use App\Mapper\PropMapper;
use App\Entity\Device;

class PropService
{

    public function __construct(
        private DeviceRepository $DeviceRepo,
        private PropRepository $PropRepo,
        private PropRepository $propsRepo,
        private PropMapper $propsMapper,
        private EntityManagerInterface $manager
    ) {

    }

    public function getAll(): Device|array
    {
        return $this->PropRepo->findAll();
    }

    public function getDevicesByProp(int $id): Device|array
    {
        $propsModel = $this->propsRepo->findByPropId($id);
        return $this->propsMapper->EntitiesToModels($propsModel);
    }

}
