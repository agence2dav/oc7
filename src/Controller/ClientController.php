<?php

namespace App\Controller;

use App\Entity\Client;
use App\Service\ClientService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    public function __construct(
        private ClientService $clientService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/client/{id}', name: 'api_client', methods: ['GET'])]
    public function client(Client $client, int $id, Request $request): JsonResponse
    {
        //define from auth
        //$id = $this->clientService->getFirstId();
        //$client = $this->clientService->getClient($id);
        $json = $this->serializerService->serialize($client, ['groups' => 'getClient']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
