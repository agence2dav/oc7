<?php

namespace App\Controller;

use OA\Items;
use OA\RequestBody;
use App\Entity\User;
use App\Entity\Client;
use App\Service\UserService;
use App\Service\ClientService;
use App\Service\SerializerService;
use OpenApi\Annotations\JsonContent;
use App\Service\SerializerJmsService;
use Nelmio\ApiDocBundle\Annotation\Model;
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
        private SerializerJmsService $serializerJmsService,
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
        $clients = $this->clientService->getAll();
        $errors = $this->validator->validate($clients);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerJmsService->serialize($clients, ['getClientSummary']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //summary of client
    #[Route('/api/clients', name: 'clientsSummary', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    public function clientSummary(): JsonResponse
    {
        //deduce client
        $logedId = $this->getUser()->id;
        $clients = $this->clientService->getClientById($logedId);
        $errors = $this->validator->validate($clients);

        //error bad client
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerJmsService->serialize($clients, ['getClientSummary']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // shows `clientId` as `required` in the OpenAPI schema (not nullable)
    //#[OA\Response(response: 200, content: new Model(type: Client::class, groups: ["clientId"]))]
    // Similarly, this will make the username `required` in the create schema
    //#[RequestBody(new Model(type: Client::class, groups: ["clientCorp"]))]

    //details of client
    #[Route('/api/clients/{id}/users', name: 'clientsDetails', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    public function clientDetails(Client $client, int $id): JsonResponse
    {
        //verif users exists
        $errors = $this->validator->validate($client);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerJmsService->serialize($client, ['getClientDetails']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //user of client
    #[Route('/api/clients/{clientId}/users/{userId}', name: 'userDetails', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    public function clientUsers(int $clientId, int $userId): JsonResponse
    {

        //cache
        $idCache = 'userdetails' . $userId;
        $this->cachePool->invalidateTags(['usersCache']);//
        $user = $this->cache->get($idCache, function (ItemInterface $item) use ($userId) {
            $item->tag('usersCache');
            return $this->userService->getUserById($userId);
        });

        //verif granted client
        $UserClientId = $user->getClient()->getId();
        if ($UserClientId != $clientId) {
            $json = $this->serializerService->serialize(['error_intrusion' => 'Access granted']);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

        //verif user exists
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerJmsService->serialize($user, ['getUserDetails']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
