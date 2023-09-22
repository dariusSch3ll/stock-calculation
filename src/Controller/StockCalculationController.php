<?php

namespace App\Controller;

use App\DTO\Warehouse;
use App\Entity\StockCalculation;

use App\Repository\StockCalculationRepository;
use App\Repository\WarehouseRepository;
use App\Service\CalculateStock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class StockCalculationController extends AbstractController
{
    public function __construct(
        private readonly WarehouseRepository        $warehouseRepository,
        private readonly StockCalculationRepository $stockCalculationRepository,
        private readonly ValidatorInterface         $validator,
        private readonly CalculateStock             $service,
    )
    {
    }

    #[Route(
        '/stock/{shop}/{product}/',
        name: 'get_stock',
        methods: ['GET'],
        format: 'application/json'
    )]
    public function getAction(Request $request, string $shop, string $product): Response
    {
        //$requestBody = json_decode($request->getContent(), true);
        //$stock = $requestBody['stock'] ?? null;
        $requestBody = json_decode($request->getContent(), true);


        $requestObject = new CreateStockCalculationRequest(
            $shop,
            $product,
            $requestBody['warehouses'] ?? null,
            $requestBody['stock'] ?? null,
            $requestBody['maxstock'] ?? null,
            $requestBody['ironstock'] ?? null
        );
        $ironstock = $requestObject->getIronstock();
        $stockCalculationRule = (new StockCalculation())
            ->setShop($shop)
            ->setSku($product)
            ->setMinimumStock($ironstock);

        $this->stockCalculationRepository->save($stockCalculationRule, true);

        $this->stockCalculationRepository->save($stockCalculationRule, true);

        return new JsonResponse([
            'shop' => $stockCalculationRule->getShop(),
            'product' => $stockCalculationRule->getSku(),
            'ironstock' => $stockCalculationRule->getMinimumStock(),
            'stock' => $calculateStock->getStockFor($product, $shop),
            'deduction' => 200
        ], 200);
    }

    #[Route(
        '/create-rule/{shop}/{product}/',
        name: 'create_stock_calculation_rule',
        methods: ['POST'],
        format: 'application/json'
    )]
    public function postAction(Request $request, string $shop, string $product): Response
    {
        $requestBody = json_decode($request->getContent(), true);

        $requestObject = new CreateStockCalculationRequest(
            $shop,
            $product,
            $requestBody['warehouses'] ?? null,
            $requestBody['stock'] ?? null,
            $requestBody['maxstock'] ?? null,
            $requestBody['ironstock'] ?? null
        );


        $errors = $this->validator->validate($requestObject);

        if (count($errors) > 0) {

            $validationErrors = [];

            foreach ($errors as $error) {
                $validationErrors[] = [
                    'message' => $error->getMessage(),
                    'code' => $error->getCode(),
                    'property' => $error->getPropertyPath(),
                ];
            }

            return JsonResponse::fromJsonString(json_encode($validationErrors), 422);
        }

        if ($this->stockCalculationRepository->findOneBy([
            'sku' => $requestObject->getProduct(),
            'shop' => $requestObject->getShop()
        ])) {
            return new JsonResponse([
                'error' => 'Product already exists'
            ], 400);
        }

        $warehouses = array_map(static fn(string $warehouse) => Warehouse::fromAny($warehouse)->toDomain(), $requestObject->getWarehouses());
        $ironstock = $requestObject->getIronstock();
        $maxstock = $requestObject->getMaxstock();

        foreach ($warehouses as $warehouse) {
            $this->warehouseRepository->save($warehouse, true);
        }


        $stockCalculationRule = (new StockCalculation())
            ->setShop($shop)
            ->setSku($product)
            ->setWarehouses($warehouses)
            ->setMinimumStock($ironstock)
            ->setMaximumStock($maxstock);



        $this->stockCalculationRepository->save($stockCalculationRule, true);


        $warehousesResponse[] = array_map(static fn(\App\Entity\Warehouse $warehouse) => (string)$warehouse, $stockCalculationRule->getWarehouses());




        return new JsonResponse([
            'shop' => $stockCalculationRule->getShop(),
            'product' => $stockCalculationRule->getSku(),
            'warehouses' => $warehousesResponse,
            'deduction' => 200
        ], 200);
    }
}


