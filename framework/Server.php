<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 17:06
 */
namespace framework;

use framework\components\es\Console;
use framework\components\ToolsAbstract;
use framework\message\Message;
use PhpAmqpLib\Message\AMQPMessage;
use service\components\Tools;
use service\models\Process;

class Server extends Application
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $serverConfig = \Yii::$app->params['soa_server_config'];
        if (!is_array($serverConfig)) {
            throw new \Exception('invalid ip port config');
        }
        $this->serverConfig = $serverConfig;
        $this->log($this->serverConfig);

        $ipPort = \Yii::$app->params['ip_port'];
        if (!is_array($ipPort)) {
            throw new \Exception('ip port config not found');
        }
        if (!isset($ipPort['host'], $ipPort['port'],
            $ipPort['localHost'], $ipPort['localPort'],
            $ipPort['msgHost'], $ipPort['msgPort'])
        ) {
            throw new \Exception('invalid ip port config');
        }
        $this->host = $ipPort['host'];
        $this->port = $ipPort['port'];
        $this->localHost = $ipPort['localHost'];
        $this->localPort = $ipPort['localPort'];
        $this->msgHost = $ipPort['msgHost'];
        $this->msgPort = $ipPort['msgPort'];
    }


    public function onReceive(\swoole_server $server, $fd, $from_id, $data)
    {
        $connection = $server->connection_info($fd, $from_id);
        if ($connection['server_port'] === $this->localPort) {
            $request = $this->getRequest()->setRawBody($data)->setFd($fd)->setRemote(false)->setServer($server);
            $server->task($request);
        } elseif ($connection['server_port'] === $this->msgPort) {
            $json = Message::unpackJson($data);
            ToolsAbstract::getRedis()->lPush(Process::getRedisMsgQueueKey(), $json);
            $server->send($fd, Message::packJson(['success' => true]));
            $this->log($json);
        } else {
            $request = $this->getRequest()->setRawBody($data)->setFd($fd)->setRemote(true)->setServer($server);
            $server->task($request);
        }
    }

    public function onTask(\swoole_server $server, $task_id, $from_id, $taskData)
    {
        try {
            if ($taskData instanceof Request) {
                /** @var \ProtocolBuffers\Message $data */
                /** @var \service\message\common\ResponseHeader $header */
                list($header, $data) = $this->handleRequest($taskData);
                if ($header instanceof \ProtocolBuffers\Message) {
                    $server->send($taskData->getFd(), Message::pack($header, $data));
                } else {
                    $server->close($taskData->getFd());
                    $e = new \Exception('Task execute error.', 100);
                    $this->logException($e);
                }
            } else {
                $e = new \Exception('Task data is not instance of request.', 101);
                $this->logException($e);
            }
            $server->finish('-CALL');
        } catch (\Exception $e) {
            $this->logException($e);
        }
    }

    public function onMQProcess($process)
    {
        try {
            swoole_set_process_name(Application::getProcessNamePrefix() . ':MQ Process-' . $process->pid);
        } catch (\Exception $e) {

        }
        Tools::getMQ()->consume('',['product.cache'], function ($msg) {
            /** @var  AMQPMessage $msg */
            Console::get()->log($msg->body, null, [__METHOD__]);
            Tools::log($msg->body);
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        });
    }

    public function serve()
    {
        $server = new \swoole_server($this->host, $this->port);
        $server->addlistener($this->localHost, $this->localPort, SWOOLE_SOCK_TCP);
        $server->addlistener($this->msgHost, $this->msgPort, SWOOLE_SOCK_TCP);
        $processes = \Yii::$app->params['custom_processes'];
        foreach ($processes as $processName => $callback) {
            $process = new \swoole_process($callback);
            $server->addProcess($process);
            $this->processes[$processName] = $process;
        }
        $server->set($this->serverConfig);
        $server->on('connect', [$this, 'onConnect']);
        $server->on('receive', [$this, 'onReceive']);
        $server->on('close', [$this, 'onClose']);
        $server->on('task', [$this, 'onTask']);
        $server->on('finish', [$this, 'onFinish']);
        $server->on('start', [$this, 'onStart']);
        $server->on('workerstart', [$this, 'onWorkerStart']);
        $server->on('workerstop', [$this, 'onWorkerStop']);
        $server->on('shutdown', [$this, 'onShutdown']);
        $server->on('workererror', [$this, 'onWorkerError']);
        $server->on('ManagerStart', [$this, 'onManagerStart']);
        $server->on('ManagerStop', [$this, 'onManagerStop']);
        $this->server = $server;
        $server->start();
    }
}