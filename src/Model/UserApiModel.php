<?php

declare(strict_types=1);

namespace App\Model;

class UserApiModel
{
    private ?string $userApiUrl = null;

    public function getUrl(): string
    {
        return $this->userApiUrl;
    }

    public function setUrl(int $id): static
    {
        $this->userApiUrl = '/api/user/' . $id;
        return $this;
    }

}
