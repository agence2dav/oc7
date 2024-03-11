<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/user/{id}', name: 'api_user', methods: ['GET'])]
    public function user(User $user, int $id): JsonResponse
    {
        //$user = $this->userService->getUser($id);
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($user, ['groups' => 'getUser']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
