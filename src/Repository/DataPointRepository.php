<?php

namespace App\Repository;

use App\Model\DataPointModel;
use App\Model\DataPointTypeEnum;
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

            new DataPointModel(1,2,3, DataPointTypeEnum::PRICEPOINT),
            new DataPointModel(4,0,8, DataPointTypeEnum::NUMBER),
            new DataPointModel(7,1,3, DataPointTypeEnum::PRICEPOINT),
            new DataPointModel(2,2,0, DataPointTypeEnum::PRICEPOINT),
            new DataPointModel(7,2,1, DataPointTypeEnum::AISCORE),



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