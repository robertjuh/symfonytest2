<?php

namespace App\Controller;

use App\Entity\MetalPriceSnapshot;
use App\Repository\DataPointRepository;
use App\Repository\MetalPriceSnapshotRepository;
use App\Service\GoldApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(
        DataPointRepository $dataRepo, 
        GoldApiService $goldApiService,
        GoldApiController $goldApiController,
        MetalPriceSnapshotRepository $goldPriceApiSnapshotRepo,
        EntityManagerInterface $entityManager
    ): Response
    {
        

        $obj = $dataRepo->returnDataPoints();
        $count = count($obj);

        $randomPoint = $obj[array_rand($obj)];

        $metalsPriceSnapshot = $goldPriceApiSnapshotRepo->findXauUsd();
        if ($metalsPriceSnapshot === null) {
                $payload = $goldApiService->getXauUsd();

                $metalsPriceSnapshot = new MetalPriceSnapshot(
                    metal: 'XAU',
                    currency: 'USD',
                    payload: $payload,
                );

                $entityManager->persist($metalsPriceSnapshot);
                $entityManager->flush();
        }

        // TODO maak dit een partial ofzo
        return $this->render('priceDataOverview/index.html.twig', [
            'snapshot' => $metalsPriceSnapshot,
        ]);

        // return $this->render('main/homepage.html.twig', [
        //     'countje' => $count,
        //     'obj' => $obj,
        //     'randomObj' => $randomPoint
        // ]);
        // return new Response('<h1>hoi</h1>');
    }
}
