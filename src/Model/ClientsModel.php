<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;


class ClientsModel
{
    private array $links;

    public function getLinks(): array
    {
        return $this->links;
    }

    public function setLinks(int $id): static
    {
        $this->links = [
            'href' => '/api/client/' . $id
        ];
        return $this;
    }

}
