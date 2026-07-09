<?php
    namespace App\Model;

    enum DataPointTypeEnum: string {
        case PRICEPOINT = "Price";
        case AISCORE = "Ai score";
        case NUMBER = "Number";
    }