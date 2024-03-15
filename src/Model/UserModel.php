<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;

class UserModel
{

    private ?int $id = null;
    private ?string $username = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->username;
    }

    public function setUserName(string $username): static
    {
        $this->username = $username;
        return $this;
    }

}
