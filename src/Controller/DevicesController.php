<?php

namespace App\Controller;

use App\Service\DeviceService;
use App\Service\SerializerService;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevicesController extends AbstractController
{
    public function __construct(
        private DeviceService $deviceService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
        private TagAwareCacheInterface $cache,
    ) {
    }

    #[Route('/api/devices', name: 'api_devices', methods: ['GET'])]
    public function devices(): JsonResponse
    {
        $idCache = 'devicesIdc';
        $devices = $this->cache->get($idCache, function (ItemInterface $item) {
            $item->tag('devicesCache');//invalidateTags
            return $this->deviceService->getDevices();
        });

        $errors = $this->validator->validate($devices);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $json = $this->serializerService->serialize($devices);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
