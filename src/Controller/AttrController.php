<?php

namespace App\Controller;

use App\Service\AttrService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AttrController extends AbstractController
{
    public function __construct(
        private AttrService $attrService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/attr/{id}', name: 'api_attr', methods: ['GET'])]
    public function attr(int $id, Request $request): JsonResponse//Attr $attr is reserved
    {
        $attr = $this->attrService->getAttr($id);
        $json = $this->serializerService->serialize($attr);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
