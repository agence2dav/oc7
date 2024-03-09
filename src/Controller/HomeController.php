<?php

namespace App\Controller;

use App\Entity\Attr;
use App\Entity\Prop;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Device;
use App\Service\AttrService;
use App\Service\PropService;
use App\Service\UserService;
use App\Service\ClientService;
use App\Service\DeviceService;
use App\Service\SerializerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
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
            'client' => '/api/client/id',
            'users' => '/api/users',
            'user' => '/api/user/{id}',
            'devices' => '/api/devices',
            'device' => '/api/device/{id}',
            'prop' => '/api/prop/{id}',
            'attr' => '/api/attr/{id}',
        ]);
    }

    #[Route('/api/clients', name: 'api_clients')]
    public function clients(Request $request): JsonResponse
    {
        $clients = $this->clientService->getClients();
        $json = $this->serializerService->entitiesToJson($clients);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/client/{id}', name: 'api_client')]
    public function client(Client $client, int $id, Request $request): JsonResponse
    {
        //define from auth
        //$id = $this->clientService->getFirstId();
        $client = $this->clientService->getClient($id);
        $json = $this->serializerService->entityToJson($client);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/users', name: 'api_users')]
    public function users(Request $request): JsonResponse
    {
        //define from auth
        $users = $this->userService->getUsers();
        $json = $this->serializerService->entitiesToJson($users);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/user/{id}', name: 'api_user')]
    public function user(User $user, int $id, Request $request): JsonResponse
    {
        $user = $this->userService->getUser($id);
        $json = $this->serializerService->entityToJson($user);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/devices', name: 'api_devices')]
    public function devices(Request $request): JsonResponse
    {
        $devices = $this->deviceService->getDevices();
        $json = $this->serializerService->entitiesToJson($devices);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/device/{id}', name: 'api_device')]
    public function device(Device $device, int $id, Request $request): JsonResponse
    {
        $device = $this->deviceService->getDevice($id);
        $json = $this->serializerService->entityToJson($device);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/prop/{id}', name: 'api_prop')]
    public function prop(Prop $prop, int $id, Request $request): JsonResponse
    {
        $prop = $this->propService->getProps($id);
        $json = $this->serializerService->entityToJson($prop);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/attr/{id}', name: 'api_attr')]
    public function attr(int $id, Request $request): JsonResponse//Attr $attr, 
    {
        $attr = $this->attrService->getAttr($id);
        $json = $this->serializerService->entityToJson($attr);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

}
