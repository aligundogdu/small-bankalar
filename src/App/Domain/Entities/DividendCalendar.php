<?php

namespace App\Domain\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\Creation;
use Common\Application\Traits\UuidTrait;
use User\Infrastructure\Repositories\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
#[ORM\Table(name: 'dividend_calendar')]
class DividendCalendar
{
    use UuidTrait;

    #[ORM\ManyToOne(targetEntity: Stock::class, cascade: ["all"])]
    #[Assert\NotBlank]
    private $stock;

    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?float $price = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4)]
    #[Assert\NotBlank]
    private ?float $percent = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $payDate;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    private ?int $year;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    private ?int $month;

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
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float|null
     */
    public function getPercent(): ?float
    {
        return $this->percent;
    }

    /**
     * @param float|null $percent
     */
    public function setPercent(?float $percent): void
    {
        $this->percent = $percent;
    }

    /**
     * @return \DateTime|null
     */
    public function getPayDate(): ?\DateTime
    {
        return $this->payDate;
    }

    /**
     * @param \DateTime|null $payDate
     */
    public function setPayDate(?\DateTime $payDate): void
    {
        $this->payDate = $payDate;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     */
    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return int|null
     */
    public function getMonth(): ?int
    {
        return $this->month;
    }

    /**
     * @param int|null $month
     */
    public function setMonth(?int $month): void
    {
        $this->month = $month;
    }


}
