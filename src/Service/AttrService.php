<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Device;
use App\Model\AttrModel;
use App\Mapper\AttrMapper;
use App\Repository\AttrRepository;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

class AttrService
{

    public function __construct(
        private DeviceRepository $deviceRepo,
        private AttrRepository $attrRepo,
        private AttrMapper $attrMapper,
        private EntityManagerInterface $manager
    ) {

    }

    public function getAll(): Collection|array
    {
        $attrModel = $this->attrRepo->findAll();
        return $this->attrMapper->EntitiesToModels($attrModel);
    }

    public function getModelById(int $id): AttrModel
    {
        $deviceEntity = $this->attrRepo->findOneById($id);
        return $this->attrMapper->EntityToModel($deviceEntity);
    }

}
