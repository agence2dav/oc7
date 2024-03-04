<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use App\Repository\DeviceRepository;
use App\Repository\AttrRepository;
use App\Mapper\AttrMapper;
use App\Entity\Device;

class AttrService
{

    public function __construct(
        private DeviceRepository $deviceRepo,
        private AttrRepository $catRepo,
        private AttrMapper $catMapper,
        private EntityManagerInterface $manager
    ) {

    }

    public function getAll(): Collection|array
    {
        $catModel = $this->catRepo->findAll();
        return $this->catMapper->EntitiesToModels($catModel);
    }

}
