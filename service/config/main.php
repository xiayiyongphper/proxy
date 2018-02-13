<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
    require(__DIR__ . '/server-config.php'),
    require(__DIR__ . '/events.php'),
    require(__DIR__ . '/soap.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'service\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => ['class' => 'service\Request'],
        'response' => ['class' => 'service\Response'],
        'errorHandler' => [
            'class' => 'service\ErrorHandler',
        ],
    ],
    'resources' => [
        'customers' => 'service\resources\customers',
        'core' => 'service\resources\core',
        'merchant' => 'service\resources\merchant',
        'sales' => 'service\resources\sales',
    ],
    'params' => $params,
];
