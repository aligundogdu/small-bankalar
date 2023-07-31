<?php

namespace App\Presentation\Api;

use App\Application\DTO\DividendDTO;
use App\Application\DTO\StockDTO;
use App\Application\Services\Dividend\InsertDividendHandler;
use App\Application\Services\Stock\InsertStockHandler;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/api/dividend/insert',
    methods: ['POST']
)]
class DividendCalendarController extends AbstractController
{


    protected InsertDividendHandler $insertDividendHandler;

    public function __construct(
        InsertDividendHandler $insertDividendHandler
    ) {
        $this->insertDividendHandler = $insertDividendHandler;
    }

    public function __invoke(Request $request): JsonResponse
    {


        $all = $request->request->all();
        $data = $all['data'] ?? [];
        foreach ($data as $item) {
            $payDate = $item['payDate'];

            if ($payDate !== null) {
                $payDate = date_create_from_format('d.m.Y', $payDate);
            }

            $dto = new DividendDTO(
                $item['stockCode'],
                (float)$item['price'],
                (float)$item['percent'],
                $payDate
            );
            $this->insertDividendHandler->handle($dto);

        }


        return new JsonResponse(['dividend' => true]);
    }
}
