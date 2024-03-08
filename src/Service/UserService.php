<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

class UserService
{

    public function __construct(
        private DeviceRepository $deviceRepo,
        private UserRepository $userRepo,
        private UserMapper $userMapper,
    ) {

    }

    public function getAll(): Collection|array
    {
        $userModel = $this->userRepo->findAll();
        return $this->userMapper->EntitiesToModels($userModel);
    }

    public function getById(int $id): User|array
    {
        return $this->userRepo->findById($id);
    }

    public function getModelById(int $id): Collection|array
    {
        $userModel = $this->userRepo->findById($id);
        return $this->userMapper->EntitiesToModels($userModel);
    }

    public function getFirstId(): int|null
    {
        return $this->userRepo->findFirstUserId();
    }

}
