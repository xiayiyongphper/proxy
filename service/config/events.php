<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/29
 * Time: 15:45
 */
return [
    'events' => [
        'sales_model_quote_submit_before' => [
            'inventory' => [
                'class' => 'service\models\sales\Observer',
                'method' => 'subtractQuoteInventory',
            ]
        ],
        'sales_model_quote_submit_failure' => [
            'inventory' => [
                'class' => 'service\models\sales\Observer',
                'method' => 'revertQuoteInventory',
            ]
        ],
        'sales_order_place_after'=>[
            'shopping_cart'=>[
                'class' => 'service\models\sales\Observer',
                'method' => 'removeOrderItems',
            ],
        ]
    ],
];