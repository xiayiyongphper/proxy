<?php
/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-6-2
 * Time: 下午1:01
 */
/**
 * @param $dbName
 * @param int $node
 * @param int $port
 * @return array
 */
function __env_get_mysql_db_config($dbName, $node = 0, $port = ENV_MYSQL_DB_PORT)
{
    switch ($node) {
        case 0:
        default:
            $config = [
                'class' => 'framework\db\Connection',
                'dsn' => sprintf('mysql:host=%s;dbname=%s;port:%s', ENV_MYSQL_DB_HOST, $dbName, $port),
                'username' => ENV_MYSQL_DB_USER,
                'password' => ENV_MYSQL_DB_PWD,
                'charset' => 'utf8',
            ];
    }
    return $config;
}

/**
 * @param int $port
 * @param int $db
 * @return array
 */
function __env_get_redis_config($port = ENV_REDIS_PORT, $db = 0)
{
    return [
        'class' => 'framework\redis\Cache',
        'options' => [
            'host' => ENV_REDIS_HOST,
            'port' => $port,
            'database' => $db,
        ],
    ];
}

/**
 * @param int $port
 * @param int $db
 * @return array
 */
function __env_get_session_config($port = ENV_REDIS_PORT, $db = 0)
{
    return [
        'class' => 'yii\redis\Session',
        'redis' => [
            'hostname' => ENV_REDIS_HOST,
            'port' => $port,
            'database' => $db,
        ]
    ];
}

function __env_get_server_config($file)
{
    return [
        'worker_num' => 16,   //工作进程数量
        'task_worker_num' => 64,
        'daemonize' => true, //是否作为守护进程
        'log_file' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'swoole.log',
        'open_length_check' => true, //打开包长检测
        'package_max_length' => 8192000, //最大的请求包长度,8M
        'package_length_type' => 'N', //长度的类型，参见PHP的pack函数
        'package_length_offset' => 0,   //第N个字节是包长度的值
        'package_body_offset' => 4,   //从第几个字节计算长度
        'heartbeat_check_interval' => 60,
        'heartbeat_idle_time' => 300,
        'task_ipc_mode' => 3,
        'message_queue_key' => ftok($file, 1),
        'discard_timeout_request' => true,
    ];
}

function __env_get_client_config()
{
    return [
        'open_length_check' => 1,
        'package_length_type' => 'N',
        'package_length_offset' => 0,       //第N个字节是包长度的值
        'package_body_offset' => 4,       //第几个字节开始计算长度
        'package_max_length' => 2000000,  //协议最大长度
        'socket_buffer_size' => 1024 * 1024 * 2, //2M缓存区
    ];
}