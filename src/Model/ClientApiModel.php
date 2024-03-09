<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;
use App\Entity\DeviceProp;
use App\Entity\Device;

class ClientApiModel
{
    private ?string $url = null;

    public function getUrl(): ?int
    {
        return $this->url;
    }

    public function setUrl(int $id): static
    {
        $this->url = '/api/client/' . $id;
        return $this;
    }

}
