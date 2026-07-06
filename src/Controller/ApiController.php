<?php

namespace App\Controller;

use App\Model\DataPointModel as ModelDataPointModel;
use App\Repository\DataPointRepository;
use DataPointModel;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/dataPoints')]
class ApiController extends AbstractController 
{

    #[Route('', methods:['GET'])]
    public function getCollection(DataPointRepository $dataRepo): Response {
         //dd($dataRepo);

        $dataPoints = $dataRepo->returnDataPoints();
        return $this->json($dataPoints);
    }


    #[Route('/{obj}', methods:['POST'])]
    public function create(ModelDataPointModel $obj): Response {
        dd($obj);
    }



    #[Route('/{id<\d+>}', methods:['GET'])]
    public function get(int $id, DataPointRepository $dataRepo): Response {

        $responsePoint = $dataRepo->find($id);

        if ($responsePoint === null) {
            throw $this->createNotFoundException('This x does not exist');
        }

        return $this->json($responsePoint);

    }
}
