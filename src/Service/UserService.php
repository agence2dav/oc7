<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Model\UserModel;
use App\Mapper\UserMapper;
use App\Mapper\UsersMapper;
use App\Service\ClientService;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;

class UserService
{

    public function __construct(
        private UserRepository $userRepo,
        private UserMapper $userMapper,
        private UsersMapper $usersMapper,
        private ClientService $clientService,
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

    public function addUser(User $user, int $clientId): void
    {
        $user->setCreatedAt(new DateTime);
        $user->setClient($this->clientService->getById($clientId));
        $this->userRepo->save($user);
    }

    public function updateUser(User $user): void
    {
        $this->userRepo->save($user);
    }

    public function delUser(User $user): void
    {
        $this->userRepo->delete($user);
    }

}
