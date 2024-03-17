<?php

namespace App\Controller;

use OA\Items;
use OA\RequestBody;
use App\Entity\Client;
use App\Service\UserService;
use OpenApi\Attributes as OA;
use App\Service\ClientService;
use App\Service\SerializerService;
use App\Service\SerializerJmsService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
//use Hateoas\UrlGenerator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
        private UrlGeneratorInterface $urlGen,
    ) {
    }

    //list of clients
    /* */
    #[Route('/api/clients/list', name: 'clientsList', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Invalid credentials to watch this')]
    #[OA\Response(
        response: 200,
        description: 'list of clients',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Client::class))
        )
    )]
    #[OA\Tag(name: 'Client')]
    public function clients(Request $request): JsonResponse
    {
        $clients = $this->clientService->getAll();
        $errors = $this->validator->validate($clients);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        //$json = $this->serializerJmsService->serialize($clients, ['getClientSummary']);
        $json = $this->serializerJmsService->hateoasSerialize($clients, $this->urlGen, ['getClientsList']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //summary of client
    #[Route('/api/clients', name: 'clientSummary', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    #[OA\Response(
        response: 200,
        description: 'summary of client',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Client::class))
        )
    )]
    #[OA\Tag(name: 'Client')]
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
        //$json = $this->serializerJmsService->serialize($clients, ['getClientSummary']);
        $json = $this->serializerJmsService->hateoasSerialize($clients, $this->urlGen, ['getClientSummary']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //details of client
    #[Route('/api/clients/{id}/users', name: 'clientDetails', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    #[OA\Response(
        response: 200,
        description: 'details of client',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Client::class))
        )
    )]
    #[OA\Tag(name: 'Client')]
    public function clientDetails(Client $client, int $id): JsonResponse
    {
        //verif users exists
        $errors = $this->validator->validate($client);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        //render
        //$json = $this->serializerJmsService->serialize($client, ['getClientDetails']);
        $json = $this->serializerJmsService->hateoasSerialize($client, $this->urlGen, ['getClientDetails']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //user of client
    #[Route('/api/clients/{clientId}/users/{userId}', name: 'userDetails', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT', message: 'Invalid credentials to watch this')]
    #[OA\Response(
        response: 200,
        description: 'detail of user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Client::class))
        )
    )]
    #[OA\Tag(name: 'Client')]
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
        //$json = $this->serializerJmsService->serialize($user, ['getUserDetails']);
        $json = $this->serializerJmsService->hateoasSerialize($user, $this->urlGen, ['getUserDetails']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
