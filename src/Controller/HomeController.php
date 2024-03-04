<?php

namespace App\Controller;

use App\Service\FixturesService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private FixturesService $fixturesService,

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

    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        $this->fixturesService->test();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
