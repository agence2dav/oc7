<?php

namespace App\Controller;

use App\Entity\Attr;
use App\Entity\Prop;
use App\Entity\Device;
use OpenApi\Attributes\Tag;
use App\Service\AttrService;
use App\Service\PropService;
use OpenApi\Attributes as OA;
use App\Service\DeviceService;
use App\Service\SerializerService;
use OpenApi\Attributes\JsonContent;
use App\Service\SerializerJmsService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
        private UrlGeneratorInterface $urlGen,
    ) {
    }

    //list of devices
    #[Route('/api/devices', name: 'devicesList', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'list of all devices',
        content: new JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: Device::class,
                    groups: ['getDevicesSummary']
                )
            )
        )
    )]
    #[OA\Parameter(
        name: 'page',
        in: 'query',
        description: 'Number of the page',
        schema: new OA\Schema(type: 'int'),
        example: '1',
    )]
    #[OA\Parameter(
        name: 'limit',
        in: 'query',
        description: 'Number of elements by page',
        schema: new OA\Schema(type: 'int'),
        example: '10',
    )]
    #[Tag(name: 'Device')]
    public function devicesList(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        //$total = $this->deviceService->getNumberOfDevices();
        $total = count($this->deviceService->getAllId());
        //cache
        $idCache = 'devicesCache';
        if($_ENV['APP_ENV']=='dev'){
            $this->cachePool->invalidateTags(['devicesCache']);
        }
        $devices = $this->cache->get($idCache, function (ItemInterface $item) use ($page, $limit) {
            $item->tag('devicesCache');
            return $this->deviceService->getAllByPage($page, $limit);
        });
        //error
        $errors = $this->validator->validate($devices);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        //render
        $json = $this->serializerJmsService->hateoasSerializePaginated($devices, $this->urlGen, ['getDevicesSummary'], 'devicesList', $page, $limit, $total);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /* 
    */

    //details of device
    #[Route('/api/devices/{id}', name: 'deviceDetails', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'details of devices',
        content: new JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: Device::class,
                    groups: ['getDevicesDetails']
                )
            ),
        )
    )]
    #[Tag(name: 'Device')]
    public function deviceDetails(Device $device, int $id): JsonResponse
    {
        //error
        $errors = $this->validator->validate($device);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        //render
        $json = $this->serializerJmsService->hateoasSerialize($device, $this->urlGen, ['getDevicesDetails']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //props of device
    #[Route('/api/devices/property/{id}', name: 'deviceProps', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'property of devices',
        content: new JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: Prop::class,
                    groups: ['getProps']
                )
            )
        )
    )]
    #[Tag(name: 'Device')]
    public function prop(Prop $prop, int $id): JsonResponse
    {
        //error
        $errors = $this->validator->validate($prop);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        //render
        $json = $this->serializerJmsService->hateoasSerialize($prop, $this->urlGen, ['getProps']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //attribut of prop
    #[Route('/api/devices/property/attribut/{id}', name: 'devicePropAttr', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'attribut for property',
        content: new JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: Attr::class,
                    groups: ['getAttr']
                )
            )
        )
    )]
    #[Tag(name: 'Device')]
    public function attr(int $id): JsonResponse //Attr $attr,  is reserved
    {
        //get
        $attr = $this->attrService->getAttrById($id);
        //error
        $errors = $this->validator->validate($attr);
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializerService->serialize($errors), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        //render
        $json = $this->serializerJmsService->hateoasSerialize($attr, $this->urlGen, ['getAttr']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
