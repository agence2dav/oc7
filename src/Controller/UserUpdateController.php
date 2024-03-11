<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserUpdateController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
        private TagAwareCacheInterface $cachePool,
    ) {
    }

    #[Route('/api/user/{id}', name: 'api_updateuser', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Invalid credentials to edit this user')]
    public function user(int $id, Request $request): JsonResponse
    {
        $this->cachePool->invalidateTags(['usersCache']);
        $user = $this->userService->getUserById($id);
        $user = $this->serializerService->deserialize($request->getContent(), USER::class, [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        $this->userService->updateUser($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
