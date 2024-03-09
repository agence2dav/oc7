<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;


class ClientsModel
{
    private ?string $clientUrl = null;

    public function getClientUrl(): string
    {
        return $this->clientUrl;
    }

    public function setClientUrl(int $id): static
    {
        $this->clientUrl = '/api/client/' . $id;
        return $this;
    }

}
