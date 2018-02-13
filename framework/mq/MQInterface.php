<?php
namespace framework\mq;
    /**
     * Created by PhpStorm.
     * User: henryzhu
     * Date: 16-7-28
     * Time: 下午5:32
     * Email: henryzxj1989@gmail.com
     */

/**
 * Interface MQInterface
 * @package framework\components\mq
 */
interface MQInterface
{
    /**
     * @param $routingKey
     * @param $data
     * @return mixed
     */
    public function publish($routingKey, $data);

    /**
     * @param $queue
     * @param array $bindingKeys
     * @param callable $callback
     */
    public function consume($queue, array $bindingKeys, callable $callback);
}