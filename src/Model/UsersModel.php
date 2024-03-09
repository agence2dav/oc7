<?php

declare(strict_types=1);

namespace App\Model;

class UsersModel
{
    private ?string $userUrl = null;

    public function getUserUrl(): string
    {
        return $this->userUrl;
    }

    public function setUserUrl(int $id): static
    {
        $this->userUrl = '/api/user/' . $id;
        return $this;
    }

}
