<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/stock/([^/]++)/([^/]++)(*:66)'
                .'|/create\\-rule/([^/]++)/([^/]++)(*:104)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        66 => [[['_route' => 'get_stock', '_format' => 'application/json', '_controller' => 'App\\Controller\\StockCalculationController::getAction'], ['shop', 'product'], ['GET' => 0], null, true, true, null]],
        104 => [
            [['_route' => 'create_stock_calculation_rule', '_format' => 'application/json', '_controller' => 'App\\Controller\\StockCalculationController::postAction'], ['shop', 'product'], ['POST' => 0], null, true, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
