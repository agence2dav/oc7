<?php

namespace App\Controller;

use App\Entity\Prop;
use App\Service\PropService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropController extends AbstractController
{
    public function __construct(
        private PropService $propService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/prop/{id}', name: 'api_prop', methods: ['GET'])]
    public function prop(int $id): JsonResponse
    {
        $prop = $this->propService->getProps($id);
        $errors = $this->validator->validate($prop);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($prop);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
