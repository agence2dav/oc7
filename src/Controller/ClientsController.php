<?php

namespace App\Controller;

use App\Service\ClientService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientsController extends AbstractController
{
    public function __construct(
        private ClientService $clientService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/clients', name: 'api_clients', methods: ['GET'])]
    public function clients(): JsonResponse
    {
        $clients = $this->clientService->getClients();
        $errors = $this->validator->validate($clients);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($clients);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
