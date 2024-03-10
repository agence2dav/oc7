<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserDeleteController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/user/{id}', name: 'api_deluser', methods: ['DELETE'])]
    public function user(User $user): JsonResponse
    {
        $this->userService->delUser($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
