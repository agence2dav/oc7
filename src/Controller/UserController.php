<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/user/{id}', name: 'api_user', methods: ['GET'])]
    public function user(User $user, int $id, Request $request): JsonResponse
    {
        //$user = $this->userService->getUser($id);
        $json = $this->serializerService->serialize($user, ['groups' => 'getUser']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
