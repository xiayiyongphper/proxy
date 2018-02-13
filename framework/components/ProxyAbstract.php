<?php
namespace framework\components;

use framework\components\es\Console;
use framework\components\es\Timeline;
use framework\Exception;
use framework\message\Message;
use service\message\common\Header;
use service\message\common\SourceEnum;
use service\message\core\ReportRouteRequest;

/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-26
 * Time: 下午2:39
 * Email: henryzxj1989@gmail.com
 */
abstract class ProxyAbstract
{
    const KEY_LOCAL_SERVICE = 'local_service';
    const KEY_REMOTE_SERVICE = 'remote_service';
    const ROUTE_ROUTE_FETCH = 'route.fetch';
    const ROUTE_ROUTE_REPORT = 'route.report';
    const ROUTE_FETCH_TOKEN = 'yggBfivOTkMOFNDm';
    const LOCAL = 'local';
    const REMOTE = 'remote';
    protected static $client = [];

    /**
     * @param $route
     * @param bool|false $remote
     * @return array|bool|mixed|null|string
     * @throws \Exception
     */
    public static function getRoute($route, $remote = false)
    {
        $parts = explode('.', $route);
        if (count($parts) != 2) {
            Exception::systemNotFound();
        }
        $modelName = $parts[0];
        if ($route == self::ROUTE_ROUTE_REPORT) {
            $ipPort = \Yii::$app->params['proxy_ip_port'];
            if (!is_array($ipPort)) {
                throw new \Exception('ip port config not found');
            }
            $host = $ipPort['host'];
            $port = $ipPort['port'];
            $localHost = $ipPort['localHost'];
            $localPort = $ipPort['localPort'];
            return $remote ? [$host, $port] : [$localHost, $localPort];
        }
        $redis = ToolsAbstract::getRedis();
        $tableName = $remote ? self::KEY_REMOTE_SERVICE : self::KEY_LOCAL_SERVICE;
        if ($redis->hExists($tableName, $modelName)) {
            $dsn = $redis->hGet($tableName, $modelName);
            list($ip, $port) = explode(':', $dsn);
            if (isset($ip, $port)) {
                return [$ip, $port];
            }
        }
        Exception::systemNotFound();
    }

    /**
     * @param Header $header
     * @param $request
     * @param bool|false $remote
     * @return Message
     * @throws \Exception
     */
    public static function sendRequest($header, $request, $remote = false)
    {
        $timeStart = microtime(true);
        try {
            list($ip, $port) = self::getRoute($header->getRoute(), $remote);
            $client = self::getClient($ip, $port);
            $client->send(Message::pack($header, $request));
            $result = $client->recv();
        } catch (\Exception $e) {
            $timeEnd = microtime(true);
            $elapsed = $timeEnd - $timeStart;
            $code = $e->getCode() > 0 ? $e->getCode() : 999;
            Timeline::get()->report($header->getRoute(), 'sendRequest', ENV_SYS_NAME, $elapsed, $code, $header->getTraceId(), $header->getRequestId());
            Console::get()->logException($e);
            throw $e;
        }
        // swoole 1.8.1有bug,close之后此task也退出了. https://github.com/swoole/swoole-src/issues/522
        //$client->close();
        $message = new Message();
        $message->unpackResponse($result);
        $timeEnd = microtime(true);
        $elapsed = $timeEnd - $timeStart;
        if ($message->getHeader()->getCode() > 0) {
            $e = new \Exception($message->getHeader()->getMsg(), $message->getHeader()->getCode());
            Console::get()->logException($e);
            throw $e;
        }
        Timeline::get()->report($header->getRoute(), 'sendRequest', ENV_SYS_NAME, $elapsed, 0, $header->getTraceId(), $header->getRequestId());
        return $message;
    }

    /**
     * @param string $eventName eg.:customer_msg.customer_registered
     * @param mixed $eventData
     * @param bool $remote
     * @return bool
     * @throws \Exception
     */
    public static function sendMessage($eventName, $eventData, $remote = false)
    {
        $timeStart = microtime(true);
        try {
            Console::get()->log($eventName, 'sendMessage.log');
            Console::get()->log($eventData, 'sendMessage.log');
            list($ip, $port) = self::getRoute($eventName, $remote);
            Console::get()->log($ip, 'sendMessage.log');
            Console::get()->log($port, 'sendMessage.log');
            $client = self::getClient($ip, $port);
            $client->send(Message::packJson($eventData));
            $result = $client->recv();
        } catch (\Exception $e) {
            $timeEnd = microtime(true);
            $elapsed = $timeEnd - $timeStart;
            $code = $e->getCode() > 0 ? $e->getCode() : 999;
            Timeline::get()->report($eventName, 'sendMessage', ToolsAbstract::getSysName(), $elapsed, $code);
            throw $e;
        }
        // swoole 1.8.1有bug,close之后此task也退出了. https://github.com/swoole/swoole-src/issues/522
        //$client->close();
        $result = Message::unpackJson($result);
        $timeEnd = microtime(true);
        $elapsed = $timeEnd - $timeStart;
        Timeline::get()->report($eventName, 'sendMessage', ToolsAbstract::getSysName(), $elapsed);
        return true;
    }

    /**
     * @param $ip
     * @param $port
     *
     * @return \swoole_client
     * @throws \Exception
     */
    protected static function getClient($ip, $port)
    {
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        // 加上跟SOAClient一样的结束符检测
        $client->set(\Yii::$app->params['soa_client_config']);
        $ret = $client->connect($ip, $port, 10);
        if (!$ret) {
            $e = new \Exception(sprintf("connect failed. Error: %s", $client->errCode));
            Console::get()->logException($e);
            throw $e;
        }
        $sockName = $client->getsockname();
        Console::get()->log("[Server]: New Proxy Client:[{$sockName['host']}:{$sockName['port']}]<->to:{$ip}:[{$port}]");
        return $client;
    }

    public static function reportServices($serviceMapping, $remote = false)
    {
        $request = new ReportRouteRequest();
        $requestData = [];
        foreach ($serviceMapping as $key => $services) {
            switch ($key) {
                case self::LOCAL:
                    $requestData[self::KEY_LOCAL_SERVICE] = $services;
                    break;
                case self::REMOTE:
                    $requestData[self::KEY_REMOTE_SERVICE] = $services;
                    break;
                default:

            }
        }
        if (count($requestData) > 0) {
            $requestData['auth_token'] = self::ROUTE_FETCH_TOKEN;
            $request->setFrom($requestData);
            $header = new Header();
            $header->setSource(SourceEnum::CORE);
            $header->setRoute(self::ROUTE_ROUTE_REPORT);
            self::sendRequest($header, $request, $remote);
        }
    }
}