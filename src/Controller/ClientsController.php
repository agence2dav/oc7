<?php

namespace App\Controller;

use App\Service\ClientService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientsController extends AbstractController
{
    public function __construct(
        private ClientService $clientService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/clients', name: 'api_clients', methods: ['GET'])]
    public function clients(Request $request): JsonResponse
    {
        $clients = $this->clientService->getClients();
        $json = $this->serializerService->serialize($clients);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
