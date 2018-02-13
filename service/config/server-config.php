<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 12:24
 */
return [
	'soa_server_config' => [
		'worker_num'               => 2,   //工作进程数量
		'task_worker_num'          => 4,
		'daemonize'                => true, //是否作为守护进程
		'log_file'                 => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'swoole.log',
		'open_length_check'        => true, //打开包长检测
		'package_max_length'       => 8192000, //最大的请求包长度,8M
		'package_length_type'      => 'N', //长度的类型，参见PHP的pack函数
		'package_length_offset'    => 0,   //第N个字节是包长度的值
		'package_body_offset'      => 4,   //从第几个字节计算长度
		'heartbeat_check_interval' => 5,   // 每5秒检测一次心跳
		'heartbeat_idle_time'      => 10,  // 10秒无心跳则断开连接
	],
	'soa_client_config'=>[
		'open_length_check'     => 1,
		'package_length_type'   => 'N',
		'package_length_offset' => 0,       //第N个字节是包长度的值
		'package_body_offset'   => 4,       //第几个字节开始计算长度
		'package_max_length'    => 2000000,  //协议最大长度
	],
	'service_mapping'=>[
		'local'=>[
			['module'=>'merchant','ip' => '172.16.10.203', 'port' => 18000],
		],
		'remote'=>[
			['module'=>'merchant','ip' => '172.16.10.203', 'port' => 8000],
		]
	],
	'ip_port'=>[
		'host'=>'0.0.0.0',
		'port'=>8000,
		'consoleHost'=>'127.0.0.1',
		'consolePort'=>8001,
		'localHost'=>'172.16.10.203',
		'localPort'=>18000
	],
	'proxy'=>[
		// 正式环境
		'product'=>[
			'app_version'=>'2.0.0',
			'host'=>'121.201.109.95',
			'port'=>9091,
			'localHost'=>'121.201.109.95',
			'localPort'=>19091
		],
		//'product_old'=>[
		//	'host'=>'121.201.110.86',
		//	'port'=>9091,
		//	'localHost'=>'121.201.110.86',
		//	'localPort'=>19091
		//],
		// 测试环境 2.0
		//'201'=>[
		//	'host'=>'172.16.10.201',
		//	'port'=>9091,
		//	'localHost'=>'172.16.10.201',
		//	'localPort'=>19091
		//],
		// 测试环境 1.0
		//'203'=>[
		//	'host'=>'172.16.10.203',
		//	'port'=>9091,
		//	'localHost'=>'172.16.10.203',
		//	'localPort'=>19091
		//],
		// 测试环境 2.0
		//'205_1'=>[
		//	'app_version'=>'1.0',
		//	'host'=>'172.16.10.205',
		//	'port'=>9091,
		//	'localHost'=>'172.16.10.205',
		//	'localPort'=>19091
		//],
		//'205_2'=>[
		//	'app_version'=>'2.0.0',
		//	'host'=>'172.16.10.205',
		//	'port'=>9091,
		//	'localHost'=>'172.16.10.205',
		//	'localPort'=>19091
		//],
	],
	'proxy_ip_port'=>[
		'host'=>'172.16.10.250',
		'port'=>9091,
		'localHost'=>'172.16.10.250',
		'localPort'=>19091
	],
];