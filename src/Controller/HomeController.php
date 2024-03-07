<?php

namespace App\Controller;

use App\Service\ClientService;
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
        private ClientService $clientService,

    ) {
    }

    #[Route('/', name: 'app_root')]
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/users', name: 'app_users')]
    public function users(Request $request): Response
    {
        $user = $this->clientService->getById(1);
        //$user = $this->clientService->getModelById(1);
        return $this->json([
            'devices' => [$user],
        ]);
    }

    #[Route('/consult', name: 'app_consult')]
    public function consultation(Request $request): Response
    {
        $device = $this->deviceService->getByName('Apple iPhone 15');
        //$device = $this->deviceService->getModelByName('Apple iPhone 15');
        return $this->json([
            'devices' => [$device],
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
