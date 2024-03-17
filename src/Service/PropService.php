<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Prop;
use App\Repository\PropRepository;

class PropService
{

    public function __construct(
        private PropRepository $propRepo,
    ) {
    }

    public function getAll(): Prop|array
    {
        return $this->propRepo->findAll();
    }

    public function getPropById(int $id): Prop
    {
        return $this->propRepo->findOneById($id);
    }

}
