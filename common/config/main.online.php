<?php
return [
	'vendorPath' => dirname(dirname(__DIR__)) . '/framework/lib/vendor',
	'language'=>'zh-CN',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'merchantDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=lelai_slim_merchant;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'productDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=lelai_booking_product_a;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'logDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=swoole_log;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'commonDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=lelai_slim_common;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'coreDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=lelai_slim_core;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'customerDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=lelai_slim_customer;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'pmsDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=lelai_booking_pms;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'proxyDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=192.168.1.12;dbname=swoole_proxy;port:3306',
			'username' => 'ilelaidev',
			'password' => 'ifenilelai@1028',
			'charset' => 'utf8',
		],
		'redisCache' => [
			'class' => 'common\redis\Cache',
			'options' => [
				'host' => '192.168.1.11',// 245
				'port' => 6379,
				'database' => 0,
			],
		],

	],
	'modules' => [
		'gridview' => [
			'class' => '\kartik\grid\Module',
			//'downloadAction' => 'export',
		],
	],
];