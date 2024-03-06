<?php

namespace App\Controller;

use App\Service\DeviceService;
use App\Service\FixturesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private FixturesService $fixturesService,
        private DeviceService $deviceService,

    ) {
    }

    #[Route('/', name: 'app_root')]
    #[Route('/home', name: 'app_home')]
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): Response
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
