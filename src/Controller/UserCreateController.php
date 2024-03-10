<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCreateController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private SerializerService $serializerService,
        private UrlGeneratorInterface $urlGenerator,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/user', name: 'api_adduser', methods: ['POST'])]
    public function user(Request $request): JsonResponse
    {
        $user = $this->serializerService->deserialize($request->getContent(), USER::class);
        $clientId = $request->toArray()['clientId'] ?? -1;
        $errors = $this->validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $this->userService->addUser($user, $clientId);
        $json = $this->serializerService->serialize($user, ['groups' => 'getuser']);
        $location = $this->urlGenerator->generate('api_user', ['id' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($json, Response::HTTP_CREATED, ["Location" => $location], true);
    }

}
