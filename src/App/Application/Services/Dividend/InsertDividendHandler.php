<?php

namespace App\Application\Services\Dividend;

use App\Application\DTO\DividendDTO;
use App\Application\DTO\StockDTO;
use App\Domain\Entities\DividendCalendar;
use App\Domain\Entities\Stock;
use App\Domain\Entities\StockHistory;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\AssignOp\Div;

class InsertDividendHandler
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function handle(DividendDTO $dividendDTO)
    {

        $stock = $this->entityManager->getRepository(Stock::class)->findOneBy(['stockCode' => $dividendDTO->stockCode]);
        if ($stock instanceof Stock) {


            $year = date('Y');
            $month = 0;

            if ($dividendDTO->payDate !== null) {
                $year = $dividendDTO->payDate->format('Y');
                $month = $dividendDTO->payDate->format('m');
            }

            $entity = $this->entityManager->getRepository(DividendCalendar::class)->findOneBy(
                [
                    'stock' => $stock,
                    'year' => $year,
                    'month' => $month
                ]
            );

            if (!$entity instanceof DividendCalendar) {
                $entity = new DividendCalendar();

                $entity->setStock($stock);
                $entity->setPercent((float)$dividendDTO->percent);
                $entity->setPrice((float)$dividendDTO->price);
                $entity->setYear($year);
                $entity->setMonth($month);
                $entity->setPayDate($dividendDTO->payDate);

                $this->entityManager->persist($entity);
                $this->entityManager->flush();

            }

            if ($month > 0) {
                $entity = $this->entityManager->getRepository(DividendCalendar::class)->findOneBy(
                    [
                        'stock' => $stock,
                        'year' => $year,
                        'month' => 0
                    ]
                );

                if ($entity instanceof DividendCalendar) {
                    $this->entityManager->remove($entity);
                    $this->entityManager->flush();
                }
            }
        }


    }

}
