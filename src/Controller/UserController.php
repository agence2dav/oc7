<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use OpenApi\Attributes as OA;
use App\Service\SerializerService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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

    //create
    #[Route('/api/users', name: 'addUser', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]

    #[OA\Response(
        response: 200,
        description: 'add user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: User::class,
                    groups: ['getUserDetails']
                )
            )
        )
    )]

    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'array',
            example: '{"clientId":"9", "username":"azerty", "email":"b@b.b", "status":"1" }',
            items: new OA\Items(ref: new Model(type: User::class, groups: ['addUser'])),
        )
    )]

    #[OA\Tag(name: 'User')]
    public function createUser(#[MapRequestPayload] User $user, Request $request): JsonResponse
    {
        //clear cache
        $this->cachePool->invalidateTags(['usersCache']);
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
        //catch error
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        //render
        $json = $this->serializerService->serialize($user, ['groups' => 'addUser']);
        $location = $this->urlGenerator->generate('userDetails', ['clientId' => $user->getClient()->getId(), 'userId' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($json, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    //update user
    #[Route('/api/users/{id}', name: 'updateUser', methods: ['PUT'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    #[OA\Response(
        response: 200,
        description: 'update user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: User::class,
                    groups: ['getUserDetails']
                )
            )
        )
    )]

    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'array',
            example: '{"username":"azerty", "email":"b@b.b", "status":"1" }',
            items: new OA\Items(ref: new Model(type: User::class, groups: ['editUser'])),
        )
    )]

    #[OA\Tag(name: 'User')]
    public function updateUser(User $user, int $id, Request $request): JsonResponse
    {
        $logedId = $this->getUser()->id;
        if ($logedId != $user->getClient()->getId()) {
            $json = $this->serializerService->serialize(['error_intrusion' => 'modification of client is forbidden']);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
        //clear cache
        $this->cachePool->invalidateTags(['usersCache']);
        $user = $this->serializerService->deserialize($request->getContent(), USER::class, [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        //update user
        $this->userService->updateUser($user);
        //render
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    //delete user
    #[Route('/api/users/{id}', name: 'delUser', methods: ['DELETE'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to edit this user')]
    #[OA\Response(
        response: 200,
        description: 'delete user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: User::class
                )
            )
        )
    )]
    #[OA\Tag(name: 'User')]
    public function deleteUser(User $user, int $id): JsonResponse
    {
        //clear cache
        $this->cachePool->invalidateTags(['usersCache']);
        //del user
        $this->userService->delUser($user);
        //render
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
