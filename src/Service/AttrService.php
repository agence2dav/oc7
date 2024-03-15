<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Attr;
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
        return $this->attrRepo->findAll();
    }

    public function getAllModel(): Collection|array
    {
        return $this->attrMapper->entitiesToModels($this->getAll());
    }

    public function getAttrById(int $id): Attr
    {
        return $this->attrRepo->findOneById($id);
    }

    public function getAttrModelById(int $id): AttrModel
    {
        $deviceEntity = $this->attrRepo->findOneById($id);
        return $this->attrMapper->entityToModel($this->getAttrById($id));
    }

}
