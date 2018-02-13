<?php
return [
	'vendorPath' => dirname(dirname(__DIR__)) . '/framework/lib/vendor',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'mainDb' => [
			'class' => 'framework\db\Connection',
			'dsn' => 'mysql:host=172.16.30.102;dbname=lelai_slim_merchant;port:3306',
			'username' => 'root',
			'password' => 'lelai!@#',
			'charset' => 'utf8',
		],
		'productDb' => [
			'class' => 'framework\db\Connection',
			'dsn' => 'mysql:host=172.16.30.102;dbname=lelai_booking_product_a;port:3306',
			'username' => 'root',
			'password' => 'lelai!@#',
			'charset' => 'utf8',
		],
		'logDb' => [
			'class' => 'framework\db\Connection',
			'dsn' => 'mysql:host=172.16.30.102;dbname=swoole_log;port:3306',
			'username' => 'root',
			'password' => 'lelai!@#',
			'charset' => 'utf8',
		],
		'commonDb' => [
			'class' => 'framework\db\Connection',
			'dsn' => 'mysql:host=172.16.30.102;dbname=lelai_slim_common;port:3306',
			'username' => 'root',
			'password' => 'lelai!@#',
			'charset' => 'utf8',
		],
		'coreDb' => [
			'class' => 'framework\db\Connection',
			'dsn' => 'mysql:host=172.16.30.102;dbname=lelai_slim_core;port:3306',
			'username' => 'root',
			'password' => 'lelai!@#',
			'charset' => 'utf8',
		],
		'customerDb' => [
			'class' => 'framework\db\Connection',
			'dsn' => 'mysql:host=172.16.30.102;dbname=lelai_slim_customer;port:3306',
			'username' => 'root',
			'password' => 'lelai!@#',
			'charset' => 'utf8',
		],
		'proxyDb' => [
			'class' => 'framework\db\Connection',
			'dsn' => 'mysql:host=172.16.30.102;dbname=swoole_proxy;port:3306',
			'username' => 'root',
			'password' => 'lelai!@#',
			'charset' => 'utf8',
		],
		'redisCache' => [
			'class' => 'common\redis\Cache',
			'options' => [
				'host' => '127.0.0.1',
				'port' => 6379,
				'database' => 0,
			],
		],
		'session' => [
			'class' => 'yii\redis\Session',
			'redis' => [
				'hostname' => '127.0.0.1',
				'port' => 6379,
				'database' => 0,
			]
		],
		//'mailer' => [
		//    'class' => 'yii\swiftmailer\Mailer',
		//    'viewPath' => '@common/mail',
		//    // send all mails to a file by default. You have to set
		//    // 'useFileTransport' to false and configure a transport
		//    // for the mailer to send real emails.
		//    'useFileTransport' => true,
		//],
		//'urlManager'=>[
		//    'enablePrettyUrl' => true, //转换目录访问
		//    'showScriptName' => false, //去除index
		//    'rules'=>[
		//        '<controller:[\w+(-)?]+>/<action:[\w+(-)?]+>'=>'<controller>/<action>',
		//    ],
		//],
	],
];
