<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserUpdateController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/user/{id}', name: 'api_updateuser', methods: ['PUT'])]
    public function user(User $user, Request $request): JsonResponse
    {
        $user = $this->serializerService->deserialize($request->getContent(), USER::class, [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        $this->userService->updateUser($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
