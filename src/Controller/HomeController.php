<?php

namespace App\Controller;

use App\Entity\Attr;
use App\Entity\Prop;
use App\Entity\User;
use App\Entity\Device;
use App\Service\AttrService;
use App\Service\PropService;
use App\Service\UserService;
use App\Service\ClientService;
use App\Service\DeviceService;
use App\Service\FixturesService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private FixturesService $fixturesService,
        private DeviceService $deviceService,
        private ClientService $clientService,
        private UserService $userService,
        private PropService $propService,
        private AttrService $attrService,
        private SerializerService $serializerService,
    ) {
    }

    /* */

    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        return $this->json([
            'users' => '/api/users',
            'user' => '/api/user/{id}',
            'devices' => '/api/devices',
            'device' => '/api/device/{id}',
            'prop' => '/api/prop/{id}',
            'attr' => '/api/attr/{id}',
        ]);
    }

    #[Route('/api/users', name: 'api_users')]
    public function users(Request $request): JsonResponse
    {
        //define from auth
        $clientId = $this->clientService->getFirstId();
        //$client = $this->clientService->getById($clientId);
        $client = $this->clientService->getApiModelById($clientId);
        $json = $this->serializerService->EntityToJson($client);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/user/{id}', name: 'api_user')]
    public function user(User $user, int $id, Request $request): JsonResponse
    {
        $user = $this->userService->getModelById($id);
        $json = $this->serializerService->EntityToJson($user);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/devices', name: 'api_devices')]
    public function devices(Request $request): JsonResponse
    {
        $devices = $this->deviceService->getAllDevices();
        $json = $this->serializerService->arrayToJson($devices);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/device/{id}', name: 'api_device')]
    public function device(Device $device, int $id, Request $request): JsonResponse
    {
        $device = $this->deviceService->getApiModelById($id);
        $json = $this->serializerService->EntityToJson($device);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/prop/{id}', name: 'api_prop')]
    public function prop(Prop $prop, int $id, Request $request): JsonResponse
    {
        $prop = $this->propService->getApiModelById($id);
        $json = $this->serializerService->EntityToJson($prop);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/attr/{id}', name: 'api_attr')]
    public function attr(int $id, Request $request): JsonResponse//Attr $attr, 
    {
        $attr = $this->attrService->getModelById($id);
        $json = $this->serializerService->EntityToJson($attr);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /* */

    #[Route('/api/testdevices', name: 'test_devices')]
    public function testDevices(Request $request): JsonResponse
    {
        //$device = $this->deviceService->getByName('Apple iPhone 15');
        $device = $this->deviceService->getModelByName('Apple iPhone 15');
        return $this->json([
            'devices' => [$device],
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): JsonResponse
    {
        [$deviceDb, $attrDb, $propDb, $devicePropDb, $res] = $this->fixturesService->devicesTables(1);
        //dd($deviceDb, $attrDb, $propDb, $devicePropDb);
        //dd($res);
        $device = $this->deviceService->getByName('Apple iPhone 15');
        //dd($device);
        return $this->render('home/test.html.twig', [
            'controller_name' => 'HomeController',
            'devices' => [$device],
        ]);
    }

}
