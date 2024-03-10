<?php

namespace App\Controller;

use App\Service\DeviceService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevicesController extends AbstractController
{
    public function __construct(
        private DeviceService $deviceService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/devices', name: 'api_devices', methods: ['GET'])]
    public function devices(Request $request): JsonResponse
    {
        $devices = $this->deviceService->getDevices();
        $errors = $this->validator->validate($devices);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($devices);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
