<?php

namespace App\Controller;

use App\Entity\Client;
use App\Service\ClientService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    public function __construct(
        private ClientService $clientService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/client/{id}', name: 'api_client', methods: ['GET'])]
    public function client(Client $client): JsonResponse
    {
        //$client = $this->clientService->getClient($id);
        $errors = $this->validator->validate($client);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($client, ['groups' => 'getClient']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
