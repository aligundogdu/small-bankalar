<?php

namespace App\Presentation\Api;

use App\Application\DTO\StockDTO;
use App\Application\Services\Stock\InsertStockHandler;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/api/stock/bulk/import',
    methods: ['POST', 'GET']
)]
class StockInsertController extends AbstractController
{

    private InsertStockHandler $stockHandler;

    public function __construct(
        InsertStockHandler $stockHandler
    ) {
        $this->stockHandler = $stockHandler;
    }

    public function __invoke(Request $request): JsonResponse
    {

        $all = $request->request->all();

        foreach ($all['data'] as $item) {

            if (isset($item['code'])) {


                if (!is_float((float)$item['lastPrice'])) {
                    $item['lastPrice'] = 0.0;
                }

                if (empty($item['name'])) {
                    $item['name'] = $item['code'];
                }

                $dto = new StockDTO(
                    $item['code'],
                    $item['name'],
                    (float)$item['volumeAmount'],
                    (float)$item['volumeCount'],
                    (float)$item['lastPrice'],
                );

                $this->stockHandler->handle($dto);
            }

        }

        return new JsonResponse(['ok' => true]);
    }
}
