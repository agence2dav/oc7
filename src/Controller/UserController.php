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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
        private UrlGeneratorInterface $urlGenerator,
        private ValidatorInterface $validator,
        private TagAwareCacheInterface $cache,
        private TagAwareCacheInterface $cachePool,
    ) {
    }

    //details of users
    /* 
    
    #[Route('/api/users/{id}', name: 'userdetails', methods: ['GET'])]
    //#[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    public function userDetails(User $user, int $id): JsonResponse
    {
        //$user = $this->userService->getUser($id);
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($user, ['groups' => 'getUser']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }*/

    //update user
    #[Route('/api/users/{id}', name: 'updateuser', methods: ['PUT'])]
    //#[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    public function updateUser(User $user, int $id, Request $request): JsonResponse
    {
        $this->cachePool->invalidateTags(['usersCache']);
        //$user = $this->userService->getUserById($id);
        $user = $this->serializerService->deserialize($request->getContent(), USER::class, [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        $this->userService->updateUser($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    //delete user
    #[Route('/api/users/{id}', name: 'deluser', methods: ['DELETE'])]
    //#[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    public function deleteUser(User $user, int $id): JsonResponse
    {
        $this->cachePool->invalidateTags(['usersCache']);
        //$user = $this->userService->getUserById($id);
        $this->userService->delUser($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    //create
    #[Route('/api/users', name: 'adduser', methods: ['POST'])]
    //#[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    public function createUser(Request $request): JsonResponse
    {
        $this->cachePool->invalidateTags(['usersCache']);
        $user = $this->serializerService->deserialize($request->getContent(), USER::class);
        $clientId = $request->toArray()['clientId'] ?? -1;
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $this->userService->addUser($user, $clientId);
        $json = $this->serializerService->serialize($user, ['groups' => 'getuser']);
        $location = $this->urlGenerator->generate('api_user', ['id' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($json, Response::HTTP_CREATED, ["Location" => $location], true);
    }

}
