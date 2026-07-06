<?php

namespace App\Controller;

use App\Model\DataPointModel as ModelDataPointModel;
use App\Repository\DataPointRepository;
use DataPointModel;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('dataPoints')]
class DataPointController extends AbstractController 
{
    #[Route('/{id<\d+>}', name: "app_datapoint_show")]
    public function show(int $id, DataPointRepository $dataRepo): Response {
        $foundObj = $dataRepo->find($id);    
    
        if ($foundObj === null) {
            throw $this->createNotFoundException('Not found bro');
        }

        return $this->render('datapoints/show.html.twig', [
            'foundObj' => $foundObj
        ]);
    
    //dd($id);
    }
}
