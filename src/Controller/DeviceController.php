<?php

namespace App\Controller;

use App\Service\AttrService;
use App\Service\PropService;
use App\Service\DeviceService;
use App\Service\SerializerService;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviceController extends AbstractController
{
    public function __construct(
        private AttrService $attrService,
        private PropService $propService,
        private DeviceService $deviceService,
        private SerializerService $serializerService,
        private ValidatorInterface $validator,
        private TagAwareCacheInterface $cache,
        private TagAwareCacheInterface $cachePool,
    ) {
    }

    //list of devices
    #[Route('/api/devices', name: 'deviceslist', methods: ['GET'])]
    public function devices(): JsonResponse
    {
        $idCache = 'devicesCache';
        $this->cachePool->invalidateTags(['devicesCache']);//
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

    //details of device
    #[Route('/api/devices/{id}', name: 'devicedetails', methods: ['GET'])]
    public function device(int $id): JsonResponse
    {
        $idCache = 'deviceCache' . $id;
        $this->cachePool->invalidateTags(['devicesCache']);//
        $device = $this->cache->get($idCache, function (ItemInterface $item) use ($id) {
            $item->tag('devicesCache');//invalidateTags
            return $this->deviceService->getDevice($id);
        });

        $errors = $this->validator->validate($device);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($device);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //props of device
    #[Route('/api/devices/property/{id}', name: 'deviceprops', methods: ['GET'])]
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

    //attribut of prop
    #[Route('/api/devices/property/attribut/{id}', name: 'devicepropattr', methods: ['GET'])]
    public function attr(int $id): JsonResponse//Attr $attr is reserved
    {
        $attr = $this->attrService->getAttrById($id);
        $errors = $this->validator->validate($attr);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $json = $this->serializerService->serialize($attr);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
