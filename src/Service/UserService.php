<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Service\ClientService;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;

class UserService
{

    public function __construct(
        private UserRepository $userRepo,
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
