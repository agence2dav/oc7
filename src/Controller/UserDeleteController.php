<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserDeleteController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
        private TagAwareCacheInterface $cachePool,
    ) {
    }

    #[Route('/api/user/{id}', name: 'api_deluser', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Invalid credentials to edit this user')]
    public function user(int $id): JsonResponse
    {
        $this->cachePool->invalidateTags(['usersCache']);
        $user = $this->userService->getUserById($id);
        $this->userService->delUser($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
