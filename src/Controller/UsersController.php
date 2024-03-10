<?php

namespace App\Controller;

use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function users(Request $request): JsonResponse
    {
        //define from auth
        $users = $this->userService->getUsers();
        $json = $this->serializerService->serialize($users);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
