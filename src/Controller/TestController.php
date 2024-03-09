<?php

namespace App\Controller;

use App\Service\DeviceService;
use App\Service\FixturesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    public function __construct(
        private FixturesService $fixturesService,
        private DeviceService $deviceService,
    ) {
    }

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
