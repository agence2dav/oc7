<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\UserModel;
use App\Mapper\UserMapper;
use App\Mapper\UsersMapper;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;

class UserService
{

    public function __construct(
        private UserRepository $userRepo,
        private UserMapper $userMapper,
        private UsersMapper $usersMapper,
    ) {

    }

    public function getUsers(): Collection|array
    {
        $usersModel = $this->userRepo->findAll();
        return $this->usersMapper->EntitiesToModels($usersModel);
    }

    public function getUser(int $id): UserModel|null
    {
        $userModel = $this->userRepo->findOneById($id);
        return $this->userMapper->EntityToModel($userModel);
    }

    public function getFirstId(): int|null
    {
        return $this->userRepo->findFirstUserId();
    }

}
