<?php

namespace App\Repository;

use App\Entity\MetalPriceSnapshot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MetalPriceSnapshotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MetalPriceSnapshot::class);
    }

    public function findXauUsd(): ?MetalPriceSnapshot
    {
        return $this->findOneBy([
            'metal' => 'XAU',
            'currency' => 'USD',
        ]);
    }
      public function findXagUsd(): ?MetalPriceSnapshot
    {
        return $this->findOneBy([
            'metal' => 'XAG',
            'currency' => 'USD',
        ]);
    }
}