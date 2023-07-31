<?php

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class StockDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $stockCode,

        public readonly ?string $stockName,

        public readonly float $volumePrice = 0,
        public readonly float $volumeCount = 0,

        public readonly float $lastPrice = 0,

//        #[Assert\NotBlank]
//        public readonly float $rating,
    )
    {
    }
}
