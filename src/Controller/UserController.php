<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use App\Service\SerializerJmsService;
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
        private SerializerJmsService $serializerService,
        private UrlGeneratorInterface $urlGenerator,
        private ValidatorInterface $validator,
        private TagAwareCacheInterface $cache,
        private TagAwareCacheInterface $cachePool,
    ) {
    }

    //update user
    #[Route('/api/users/{id}', name: 'updateUser', methods: ['PUT'])]
    //#[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    public function updateUser(User $user, int $id, Request $request): JsonResponse
    {
        //clear cache
        $this->cachePool->invalidateTags(['usersCache']);

        //alternative source of datas
        //$user = $this->userService->getUserById($id);

        $user = $this->serializerService->deserialize($request->getContent(), USER::class, [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        //update user
        $this->userService->updateUser($user);

        //render
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    //delete user
    #[Route('/api/users/{id}', name: 'delUser', methods: ['DELETE'])]
    //#[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    public function deleteUser(User $user, int $id): JsonResponse
    {
        //clear cache
        $this->cachePool->invalidateTags(['usersCache']);

        //alternative source of datas
        //$user = $this->userService->getUserById($id);

        //del user
        $this->userService->delUser($user);

        //render
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    //create
    #[Route('/api/users', name: 'addUser', methods: ['POST'])]
    //#[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    public function createUser(Request $request): JsonResponse
    {
        //clear cache
        $this->cachePool->invalidateTags(['usersCache']);
        $user = $this->serializerService->deserialize($request->getContent(), USER::class);
        $clientId = $request->toArray()['clientId'] ?? -1;

        //verif user exists
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //verif relation with host client
        $logedId = $this->getUser()->id;
        if ($logedId != $clientId) {
            $json = $this->serializerService->serialize(['error_intrusion' => 'Access granted']);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

        //add user
        $this->userService->addUser($user, $clientId);

        //catch error...
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerService->serialize($user, ['groups' => 'getuser']);
        $location = $this->urlGenerator->generate('userdetails', ['clientId' => $user->getClient()->getId(), 'userId' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($json, Response::HTTP_CREATED, ['Location' => $location], true);
    }

}
