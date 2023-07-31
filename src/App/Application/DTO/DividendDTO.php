<?php

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class DividendDTO
{
    public function __construct(

        #[Assert\NotBlank]
        public readonly string $stockCode,

        #[Assert\NotBlank]
        public readonly float $price,

        #[Assert\NotBlank]
        public readonly float $percent,

        public readonly ?\DateTime $payDate = null,

    ) {
    }
}
