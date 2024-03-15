<?php

namespace App\Controller;

use App\Entity\Attr;
use App\Entity\Prop;
use App\Entity\Device;
use App\Service\AttrService;
use App\Service\PropService;
use App\Service\DeviceService;
use App\Service\SerializerService;
use App\Service\SerializerJmsService;
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
        private SerializerJmsService $serializerJmsService,
        private ValidatorInterface $validator,
        private TagAwareCacheInterface $cache,
        private TagAwareCacheInterface $cachePool,
    ) {
    }

    //list of devices
    #[Route('/api/devices', name: 'devicesList', methods: ['GET'])]
    public function devices(): JsonResponse
    {
        //cache
        $idCache = 'devicesCache';
        $this->cachePool->invalidateTags(['devicesCache']);//
        $devices = $this->cache->get($idCache, function (ItemInterface $item) {
            $item->tag('devicesCache');//invalidateTags
            return $this->deviceService->getAll();
        });

        //error
        $errors = $this->validator->validate($devices);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerJmsService->serialize($devices, ['getDevicesSummary']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //details of device
    #[Route('/api/devices/{id}', name: 'deviceDetails', methods: ['GET'])]
    public function device(Device $device, int $id): JsonResponse
    {

        //error
        $errors = $this->validator->validate($device);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerJmsService->serialize($device, ['getDevicesDetails']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //props of device
    #[Route('/api/devices/property/{id}', name: 'deviceProps', methods: ['GET'])]
    public function prop(Prop $prop, int $id): JsonResponse
    {
        //get
        //$prop = $this->propService->getProp($id);

        //error
        $errors = $this->validator->validate($prop);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerJmsService->serialize($prop, ['getProps']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //attribut of prop
    #[Route('/api/devices/property/attribut/{id}', name: 'devicePropAttr', methods: ['GET'])]
    public function attr(int $id): JsonResponse//Attr $attr,  is reserved
    {
        //get
        $attr = $this->attrService->getAttrById($id);
        //dd($attr);

        //error
        $errors = $this->validator->validate($attr);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //render
        $json = $this->serializerJmsService->serialize($attr, ['getAttr']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
