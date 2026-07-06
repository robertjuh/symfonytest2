<?php

namespace App\Repository;

use App\Model\DataPointModel;
use Psr\Log\LoggerInterface;
use Symfony\Flex\Response;

class DataPointRepository {

    public function __construct(private LoggerInterface $logger)
    {
        // throw new \Exception('Not implemented');
    }

    public function returnDataPoints(): array {
        $this->logger->info('returning coll');

        return [

            new DataPointModel(1,2,3),
            new DataPointModel(4,0,8),
            new DataPointModel(7,1,3),
            new DataPointModel(2,2,0),
            new DataPointModel(7,2,1),



        ];

    } 

    public function find(int $id): ?DataPointModel {
       foreach ($this->returnDataPoints() as $dataPointje) {
            if ($dataPointje->getX() === $id) {
                return $dataPointje;
            }
       }

       return null;
    }

}