<?php

namespace App\Service;

use App\DTO\Warehouse;
use App\Entity\StockCalculation;
use App\Controller\StockCalculationController;
use App\Repository\StockCalculationRepository;
use App\Repository\WarehouseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalculateStock
{
    public function __construct(
        private readonly WarehouseRepository        $warehouseRepository,
        private readonly StockCalculationRepository $stockCalculationRepository,
        private readonly ValidatorInterface         $validator,


    )
    {
    }
    public function getCalculateStock(): int
    {
        $request = Request::createFromGlobals();
        $requestBody = json_decode($request->getContent(), true);
        $stock = $requestBody['stock'] ?? null;
        $ironstock = $requestBody['ironstock'] ?? null;

        $stock -= $ironstock;

        return $stock;
    }

    public function getStockFor($product, $shop): int
    {

        $stock = $this->stockCalculationRepository->findOneBy(['sku' => $product, 'shop' => $shop]);
        $min = $stock->getMinimumStock();
        $max = $stock->getMaximumStock();

        return 0;

    }

}
