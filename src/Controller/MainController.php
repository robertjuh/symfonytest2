<?php

namespace App\Controller;

use App\Repository\DataPointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(DataPointRepository $dataRepo): Response
    {
        

        $obj = $dataRepo->returnDataPoints();
        $count = count($obj);

        $randomPoint = $obj[array_rand($obj)];

        return $this->render('main/homepage.html.twig', [
            'countje' => $count,
            'obj' => $obj,
            'randomObj' => $randomPoint
        ]);
        // return new Response('<h1>hoi</h1>');
    }
}
