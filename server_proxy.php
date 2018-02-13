<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/17
 * Time: 11:46
 */



register_shutdown_function( "fatal_handler" );

function fatal_handler() {
	$errfile = "unknown file";
	$errstr  = "shutdown";
	$errno   = E_CORE_ERROR;
	$errline = 0;

	$error = error_get_last();

	if( $error !== NULL) {
		/*
		$errno   = $error["type"];
		$errfile = $error["file"];
		$errline = $error["line"];
		$errstr  = $error["message"];

		error_mail(format_error( $errno, $errstr, $errfile, $errline));
		*/
		echo 'shit happens'.PHP_EOL;
		print_r($error);
	}
}


defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require(__DIR__ . '/framework/autoload.php');
require(__DIR__ . '/common/config/bootstrap.php');
require(__DIR__ . '/service/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/common/config/main.php'),
	require(__DIR__ . '/common/config/main-local.php'),
	require(__DIR__ . '/service/config/main.php'),
	require(__DIR__ . '/service/config/main-local.php')
);
$application = new \service\Application($config);

global $argv;
$startFile = $argv[0];

if(!isset($argv[1])) {
	exit("Usage: php {$startFile} {start|stop|reload}\n");
}


$cmd = $argv[1];
if($cmd=='start'){
	$application = new \service\Server($config);
	$application->serve();
}else{
	$client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
	$client->connect('127.0.0.1', 9502);
	$send = pack('N', \common\models\TStringFuncFactory::create()->strlen($cmd)) . $cmd;
	$client->send($send);
	$result = $client->recv();
	echo $result;
	$client->close();
}