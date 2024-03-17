<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Attr;
use App\Repository\AttrRepository;

class AttrService
{

    public function __construct(
        private AttrRepository $attrRepo,
    ) {

    }

    public function getAttrById(int $id): Attr
    {
        return $this->attrRepo->findOneById($id);
    }

}
