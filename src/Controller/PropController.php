<?php

namespace App\Controller;

use App\Entity\Prop;
use App\Service\PropService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropController extends AbstractController
{
    public function __construct(
        private PropService $propService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/prop/{id}', name: 'api_prop', methods: ['GET'])]
    public function prop(Prop $prop, int $id, Request $request): JsonResponse
    {
        $prop = $this->propService->getProps($id);
        $json = $this->serializerService->serialize($prop);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
