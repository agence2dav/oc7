<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Device;
use App\Mapper\PropMapper;
use App\Model\PropApiModel;
use App\Mapper\PropApiMapper;
use App\Repository\PropRepository;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;

class PropService
{

    public function __construct(
        private DeviceRepository $DeviceRepo,
        private PropRepository $propRepo,
        private PropMapper $propMapper,
        private PropApiMapper $propApiMapper,
        private EntityManagerInterface $manager
    ) {

    }

    public function getAll(): Device|array
    {
        return $this->propRepo->findAll();
    }

    public function getDevicesByProp(int $id): Device|array
    {
        $propsModel = $this->propRepo->findByPropId($id);
        return $this->propMapper->EntitiesToModels($propsModel);
    }

    public function getApiModelById(int $id): PropApiModel
    {
        $deviceEntity = $this->propRepo->findOneById($id);
        return $this->propApiMapper->EntityToModel($deviceEntity);
    }

}
