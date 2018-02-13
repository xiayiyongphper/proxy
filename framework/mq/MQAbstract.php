<?php
namespace framework\mq;

/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-28
 * Time: 下午6:03
 * Email: henryzxj1989@gmail.com
 */

use framework\components\es\Console;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class MQAbstract
 * @package framework\components\mq
 */
abstract class MQAbstract implements MQInterface
{
    protected $host = '172.16.10.239';
    protected $port = 5672;
    protected $user = 'lelai';
    protected $pwd = '123456';
    const TYPE_TOPIC = 'topic';
    const EXCHANGE = 'logs';

    /**
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * @var AMQPChannel
     */
    protected $channel;


    /**
     * @return AMQPStreamConnection
     */
    protected function getConnection()
    {
        if (!$this->connection) {
            $this->connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pwd);
        }
        return $this->connection;
    }

    /**
     * @return AMQPChannel
     */
    protected function getChannel()
    {
        if (!$this->channel) {
            $this->channel = $this->getConnection()->channel();
        }
        return $this->channel;
    }

    public function publish($routingKey, $data)
    {
        $channel = $this->getChannel();

        $channel->exchange_declare(self::EXCHANGE, self::TYPE_TOPIC, false, false, false);

        if (strlen($data) == 0) {
            Console::get()->log('Invalid data to publish');
        }

        $msg = new AMQPMessage($data,
            array('delivery_mode' => 2) # make message persistent
        );

        $channel->basic_publish($msg, self::EXCHANGE, $routingKey);

        Console::get()->log(" [x] Sent , $routingKey, :$data");
    }


    /**
     * @param $queue
     * @param array $bindingKeys
     * @param callable $callback
     */
    public function consume($queue, array $bindingKeys, callable $callback)
    {
        $channel = $this->getChannel();

        $channel->exchange_declare(self::EXCHANGE, self::TYPE_TOPIC, false, false, false);

        $channel->queue_declare($queue, false, true, false, false);

        if (empty($bindingKeys)) {
            Console::get()->log('Invalid binding keys');
            exit(1);
        }

        foreach ($bindingKeys as $bindingKey) {
            $channel->queue_bind($queue, self::EXCHANGE, $bindingKey);
        }
        Console::get()->log(' [*] Waiting for logs. To exit press CTRL+C');

        $channel->basic_consume($queue, '', false, true, false, false, $callback);
        while (count($channel->callbacks)) {
            $channel->wait();
        }

    }

    public function close()
    {
        if ($this->channel) {
            $this->channel->close();
        }

        if ($this->connection) {
            $this->connection->close();
        }
    }
}