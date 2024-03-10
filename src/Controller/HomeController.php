<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
    ) {
    }

    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        return $this->json([
            'clients' => '/api/clients',
            'client' => '/api/client/id',
            'users' => '/api/users',
            'user' => '/api/user/{id}',
            'devices' => '/api/devices',
            'device' => '/api/device/{id}',
            'prop' => '/api/prop/{id}',
            'attr' => '/api/attr/{id}',
        ]);
    }

}
