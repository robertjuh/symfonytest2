<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class mainController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return new Response('<h1>hoi</h1>');
    }
}
