<?php

namespace App\Domain\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\Creation;
use Common\Application\Traits\UuidTrait;
use User\Infrastructure\Repositories\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
#[ORM\Table(name: 'stocks')]
class Stock
{
    use UuidTrait;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    private ?string $stockCode = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    private ?string $stockName = null;

    #[ORM\Column(type: Types::STRING, length: 3)]
    #[Assert\NotBlank]
    private ?string $language = 'TR';

    #[ORM\Column(type: Types::STRING, length: 5)]
    #[Assert\NotBlank]
    private ?string $marketCode = 'BIST';


    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?float $volumePrice = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?float $volumeCount = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?float $lastPrice = 0;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    private ?int $way = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?\DateTime $lastUpdate;

    /**
     * @return string|null
     */
    public function getStockCode(): ?string
    {
        return $this->stockCode;
    }

    /**
     * @param string|null $stockCode
     */
    public function setStockCode(?string $stockCode): void
    {
        $this->stockCode = $stockCode;
    }

    /**
     * @return string|null
     */
    public function getStockName(): ?string
    {
        return $this->stockName;
    }

    /**
     * @param string|null $stockName
     */
    public function setStockName(?string $stockName): void
    {
        $this->stockName = $stockName;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string|null
     */
    public function getMarketCode(): ?string
    {
        return $this->marketCode;
    }

    /**
     * @return float|null
     */
    public function getVolumePrice(): ?float
    {
        return $this->volumePrice;
    }

    /**
     * @param float|null $volumePrice
     */
    public function setVolumePrice(?float $volumePrice): void
    {
        $this->volumePrice = $volumePrice;
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
     * @return float|null
     */
    public function getVolumeCount(): ?float
    {
        return $this->volumeCount;
    }

    /**
     * @param float|null $volumeCount
     */
    public function setVolumeCount(?float $volumeCount): void
    {
        $this->volumeCount = $volumeCount;
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

    /**
     * @return int|null
     */
    public function getWay(): ?int
    {
        return $this->way;
    }

    /**
     * @param int|null $way
     */
    public function setWay(?int $way): void
    {
        $this->way = $way;
    }



}
