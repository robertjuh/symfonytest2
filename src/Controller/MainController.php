<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
        $count = 420;

        $obj = [
            "name" => 'test1',
            "class" => 'test2',
            "captain" => 'test3',
            "status" => 'test4',
        ];

        return $this->render('main/homepage.html.twig', [
            'countje' => $count,
            'obj' => $obj,
        ]);
        // return new Response('<h1>hoi</h1>');
    }
}
