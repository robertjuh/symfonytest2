<?php
namespace App\Model;

class DataPointModel {
   
    public function __construct(private int $x, private int $y, private int $z)
    {
        
        // throw new \Exception('Not implemented');
    }


    public function getX(): int {
        return $this->x;
    }
    public function getY(): int {
        return $this->y;
    }
    public function getZ(): int {
        return $this->z;
    }
}