<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Service\UserService;
use App\Service\ClientService;
use App\Service\SerializerService;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private ClientService $clientService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
        private TagAwareCacheInterface $cache,
        private TagAwareCacheInterface $cachePool,
    ) {
    }

    //list of clients
    #[Route('/api/clients/list', name: 'clientslist', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Invalid credentials to watch this')]
    public function clients(): JsonResponse
    {
        $clients = $this->clientService->getClientsList();
        $errors = $this->validator->validate($clients);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($clients);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //summary of client
    #[Route('/api/clients', name: 'clientssummary', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    public function clientSummary(): JsonResponse
    {
        $logedId = $this->getUser()->id;
        $clients = $this->clientService->getClientSummary($logedId);
        $errors = $this->validator->validate($clients);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($clients);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // shows `clientId` as `required` in the OpenAPI schema (not nullable)
    //#[OA\Response(response: 200, content: new Model(type: Client::class, groups: ["clientId"]))]
    // Similarly, this will make the username `required` in the create  schema
    //#[OA\RequestBody(new Model(type: Client::class, groups: ["clientCorp"]))]

    //details of client
    #[Route('/api/clients/{id}/users', name: 'clientsdetails', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    public function clientDetails(Client $client, int $id): JsonResponse
    {
        $logedId = $this->getUser()->id;
        if ($logedId != $id) {
            $json = $this->serializerService->serialize(['error_intrusion' => 'Access granted']);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

        $idCache = 'clientsdetails';
        $users = $this->cache->get($idCache, function (ItemInterface $item) use ($client) {
            $item->tag('usersCache');
            return $this->clientService->getClientDetails($client);
        });

        $errors = $this->validator->validate($users);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $json = $this->serializerService->serialize($users);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //user of client
    #[Route('/api/clients/{id}/users/{userId}', name: 'userdetails', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    public function clientUsers(int $id, int $userId): JsonResponse
    {
        $logedId = $this->getUser()->id;
        if ($logedId != $id) {
            $json = $this->serializerService->serialize(['error_intrusion' => 'Access granted']);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

        $idCache = 'userdetails';
        $user = $this->cache->get($idCache, function (ItemInterface $item) use ($userId) {
            $item->tag('usersCache');
            return $this->userService->getUser($userId);
        });
        $this->cachePool->invalidateTags(['userdetails']);

        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $json = $this->serializerService->serialize($user);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
