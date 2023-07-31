<?php

namespace App\Domain\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\Creation;
use Common\Application\Traits\UuidTrait;
use User\Infrastructure\Repositories\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
#[ORM\Table(name: 'stock_history')]
class StockHistory
{
    use UuidTrait;

    #[ORM\ManyToOne(targetEntity: Stock::class, cascade: ["all"])]
    #[Assert\NotBlank]
    private $stock;

    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?float $lastPrice = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?\DateTime $lastUpdate;

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return float|null
     */
    public function getLastPrice(): ?float
    {
        return $this->lastPrice;
    }

    /**
     * @param float|null $lastPrice
     */
    public function setLastPrice(?float $lastPrice): void
    {
        $this->lastPrice = $lastPrice;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastUpdate(): ?\DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime|null $lastUpdate
     */
    public function setLastUpdate(?\DateTime $lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }



}
