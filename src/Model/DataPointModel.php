<?php
namespace App\Model;

use App\Model\DataPointTypeEnum;

class DataPointModel {
   
    public function __construct(private int $x, private int $y, private int $z, private DataPointTypeEnum $type)
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
    public function getType(): DataPointTypeEnum {
        return $this->type;
    }

    public function getInfoString(): string {
        return $this->type->value;
    }
}