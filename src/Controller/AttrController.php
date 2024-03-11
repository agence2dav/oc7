<?php

namespace App\Controller;

use App\Service\AttrService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AttrController extends AbstractController
{
    public function __construct(
        private AttrService $attrService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/attr/{id}', name: 'api_attr', methods: ['GET'])]
    public function attr(int $id): JsonResponse//Attr $attr is reserved
    {
        $attr = $this->attrService->getAttr($id);
        $errors = $this->validator->validate($attr);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($attr);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
