<?php

namespace App\Controller;

use App\Entity\Device;
use App\Service\DeviceService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviceController extends AbstractController
{
    public function __construct(
        private DeviceService $deviceService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/device/{id}', name: 'api_device', methods: ['GET'])]
    public function device(Device $device, int $id, Request $request): JsonResponse
    {
        $device = $this->deviceService->getDevice($id);
        $errors = $this->validator->validate($device);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($device);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
