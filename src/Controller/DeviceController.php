<?php

namespace App\Controller;

use App\Entity\Device;
use App\Service\DeviceService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviceController extends AbstractController
{
    public function __construct(
        private DeviceService $deviceService,
        private SerializerService $serializerService,
    ) {
    }

    #[Route('/api/device/{id}', name: 'api_device', methods: ['GET'])]
    public function device(Device $device, int $id, Request $request): JsonResponse
    {
        $device = $this->deviceService->getDevice($id);
        $json = $this->serializerService->serialize($device);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
