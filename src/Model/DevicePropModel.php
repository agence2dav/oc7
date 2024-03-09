<?php

declare(strict_types=1);

namespace App\Model;

class DevicePropModel
{
    private string $propUrl;

    public function getPropUrl(): string
    {
        return $this->propUrl;
    }

    public function setPropUrl(int $id): static
    {
        $this->propUrl = '/api/prop/' . $id;
        return $this;
    }

}
