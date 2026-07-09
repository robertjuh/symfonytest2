<?php

namespace App\Controller;

use App\Entity\MetalPriceSnapshot;
use App\Repository\MetalPriceSnapshotRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\GoldApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// https://www.goldapi.io/dashboard
class GoldApiController extends AbstractController
{
    // Loads gold now but should be dynamuc
    #[Route('/gold', name: 'app_gold')]
    public function loadMetalsPrices(
        MetalPriceSnapshotRepository $goldPriceRepository,
        GoldApiService $goldApiClient,
        EntityManagerInterface $entityManager,
    ): Response {
        $snapshot = $goldPriceRepository->findXauUsd();

        if ($snapshot === null) {
            $payload = $goldApiClient->getXauUsd();

            $snapshot = new MetalPriceSnapshot(
                metal: 'XAU',
                currency: 'USD',
                payload: $payload,
            );

            $entityManager->persist($snapshot);
            $entityManager->flush();
        }

        return $this->render('priceDataOverview/index.html.twig', [
            'snapshot' => $snapshot,
        ]);
    }


    // This does with a refresh, i am not sure if this is good practice
    #[Route('/gold/refresh', name: 'app_gold_refresh', methods: ['POST'])]
    public function refresh(
        Request $request,
        MetalPriceSnapshotRepository $goldPriceRepository,
        GoldApiService $goldApiClient,
        EntityManagerInterface $entityManager,
    ): RedirectResponse {
        if (!$this->isCsrfTokenValid('refresh_gold_price', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $snapshot = $goldPriceRepository->findXauUsd();

        $payload = $goldApiClient->getXauUsd();

        if ($snapshot === null) {
            $snapshot = new MetalPriceSnapshot(
                metal: 'XAU',
                currency: 'USD',
                payload: $payload,
            );

            $entityManager->persist($snapshot);
        } else {
            $snapshot->updateFromPayload($payload);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_gold');
    }


    #[Route('/gold/refresh-json', name: 'app_gold_refresh_json', methods: ['POST'])]
    public function refreshJson(
        Request $request,
        MetalPriceSnapshotRepository $goldPriceRepository,
        GoldApiService $goldApiClient,
        EntityManagerInterface $entityManager,
    ): JsonResponse {
        if (!$this->isCsrfTokenValid('refresh_gold_price', $request->request->get('_token'))) {
            return $this->json([
                'success' => false,
                'error' => 'Invalid CSRF token.',
            ], 403);
        }

        $snapshot = $goldPriceRepository->findXauUsd();

        $payload = $goldApiClient->getXauUsd();

        if ($snapshot === null) {
            $snapshot = new MetalPriceSnapshot(
                metal: 'XAU',
                currency: 'USD',
                payload: $payload,
            );

            $entityManager->persist($snapshot);
        } else {
            $snapshot->updateFromPayload($payload);
        }

        $entityManager->flush();

        return $this->json([
            'success' => true,
            'metal' => $snapshot->getMetal(),
            'currency' => $snapshot->getCurrency(),
            'price' => $snapshot->getPrice(),
            'storedAt' => $snapshot->getCreatedAt()->format('Y-m-d H:i:s'),
            'payload' => $snapshot->getPayload(),
        ]);
    }
}