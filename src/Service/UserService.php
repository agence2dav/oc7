<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Service\ClientService;
use App\Model\UserDetailsModel;
use App\Mapper\UserDetailsMapper;
use App\Mapper\UserSummaryMapper;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;

class UserService
{

    public function __construct(
        private UserRepository $userRepo,
        private UserDetailsMapper $userDetailsMapper,
        private UserSummaryMapper $userSummaryMapper,
        private ClientService $clientService,
    ) {

    }

    public function getUserById(int $id): User|null
    {
        return $this->userRepo->findOneById($id);
    }

    public function getUsersByCientId(int $id): Collection|array
    {
        return $this->userRepo->findUsersByClientId($id);
    }

    public function getUsers(int $id): Collection|array
    {
        return $this->userSummaryMapper->entitiesToModels($this->getUsersByCientId($id));
    }

    public function getUser(int $id): UserDetailsModel|null
    {
        return $this->userDetailsMapper->entityToModel($this->getUserById($id));
    }

    public function getUserDetails(User $user): UserDetailsModel|null
    {
        return $this->userDetailsMapper->entityToModel($user);
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
