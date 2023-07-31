<?php

namespace App\Application\Services\Stock;

use App\Application\DTO\StockDTO;
use App\Domain\Entities\Stock;
use App\Domain\Entities\StockHistory;
use Doctrine\ORM\EntityManagerInterface;

class InsertStockHandler
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function handle(StockDTO $stockDTO)
    {
        $entity = $this->entityManager->getRepository(Stock::class)->findOneBy(['stockCode' => $stockDTO->stockCode]);

        if (!$entity instanceof Stock) {
            $entity = new Stock();
            $entity->setStockCode($stockDTO->stockCode);
            if ($stockDTO->stockName) {
                $entity->setStockName($stockDTO->stockName);
            }
        }

        $beforePrice = $entity->getLastPrice();
        
        $way = 0;
        if ($stockDTO->lastPrice < $beforePrice) {
            $way = 1;
        }

        if ($stockDTO->lastPrice > $beforePrice) {
            $way = 2;
        }

        $entity->setLastPrice($stockDTO->lastPrice);


        $entity->setVolumePrice($stockDTO->volumePrice);
        $entity->setVolumeCount($stockDTO->volumeCount);
        $entity->setLastUpdate(new \DateTime());
        $entity->setWay($way);


        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $history = new StockHistory();
        $history->setLastUpdate(new \DateTime());
        $history->setStock($entity);
        $history->setLastPrice($stockDTO->lastPrice);

        $this->entityManager->persist($history);
        $this->entityManager->flush();

    }

}
