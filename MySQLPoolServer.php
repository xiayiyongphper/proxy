<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/17
 * Time: 10:43
 */
class MySQLPoolServer
{
    protected $_server;
    /**
     * @var \Pdo
     */
    protected $_pdo;
    protected $_dsn = 'mysql:host=localhost;port=3306;dbname=test';
    protected $_user = 'root';
    protected $_pwd = '123456';
    protected $_lastExecutionTime;
    protected $_params = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8';",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true,
    );
    protected $_interactiveTimeout = 180;

    public function __construct()
    {
        $this->_server = new swoole_server('0.0.0.0', 9502);
        $this->_server->set(array(
            'worker_num' => 2,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 3,
            'debug_mode' => 0,
            'task_worker_num' => 2
        ));
        $this->_server->on('WorkerStart', array($this, 'onWorkerStart'));
        $this->_server->on('Connect', array($this, 'onConnect'));
        $this->_server->on('Receive', array($this, 'onReceive'));
        $this->_server->on('Close', array($this, 'onClose'));

        $this->_server->on('Task', array($this, 'onTask'));
        $this->_server->on('Finish', array($this, 'onFinish'));
        $this->_server->start();
    }

    public function onWorkerStart($serv, $worker_id)
    {
        echo 'Worker Start:' . $worker_id . PHP_EOL;
        if ($worker_id >= $serv->setting['worker_num']) {
            $this->connect();
        }
    }

    protected function _connect()
    {
        $this->_pdo = new PDO(
            $this->_dsn,
            $this->_user,
            $this->_pwd,
            $this->_params
        );
        return $this;
    }

    protected function connect()
    {
        try {
            if (!$this->_pdo) {
                $this->_connect();
            }
            $this->_pdo->getAttribute(\PDO::ATTR_SERVER_INFO);
        } catch (\Exception $e) {
            $this->_connect();
        }
    }

    public function onConnect($serv, $fd, $from_id)
    {
        echo "client {$fd} connected" . PHP_EOL;
    }

    public function onReceive($serv, $fd, $from_id, $data)
    {
        $char_str = 'abcdefghijklmnopqrstuvwxyz';
        $name = substr(str_shuffle($char_str), 0, 4);
        $timestamp = time();
        $sql = array(
            'sql' => 'INSERT INTO test(`id`,`workerid`,`name`,`timestamp`) VALUES (NULL,?,?,?);',
            'param' => array($from_id, $name, $timestamp),
            'fd' => $fd,
        );
        $serv->task(json_encode($sql));
    }

    public function onClose($serv, $fd, $from_id)
    {
        echo "client {$fd} connected" . PHP_EOL;
    }

    public function onTask($serv, $task_id, $from_id, $data)
    {
        try {
            $this->connect();
            $sql = json_decode($data, true);
            $statement = $this->_pdo->prepare($sql['sql']);
            $statement->execute($sql['param']);
            $serv->send($sql['fd'], 'INSERT SUCCESS' . $this->_pdo->lastInsertId());
            return true;
        } catch (PDOException $e) {
            echo 'got PDO exception' . PHP_EOL;
            return false;
        } catch (\Exception $e) {
            echo 'got exception' . PHP_EOL;
            return false;
        }
    }

    public function onFinish($serv, $task_id, $data)
    {
        echo "Task {$task_id} finish" . PHP_EOL;
    }
}

$poolServer = new MySQLPoolServer();