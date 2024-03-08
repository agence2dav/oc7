<?php

namespace App\Controller;

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
        private SerializerService $serializerService,
    ) {
    }

    /* */

    #[Route('/', name: 'app_root')]
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/users', name: 'test_users')]
    public function users(Request $request): JsonResponse
    {
        $firstClientId = $this->clientService->getFirstId();
        $client = $this->clientService->getById($firstClientId);
        //$client = $this->clientService->getModelById($firstClientId);
        $json = $this->serializerService->arrayToJson($client);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/devices', name: 'test_devices')]
    public function devices(Request $request): JsonResponse
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
