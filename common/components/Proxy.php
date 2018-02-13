<?php
namespace common\components;

use service\components\Tools;
use service\message\core\FetchRouteRequest;
use service\message\core\FetchRouteResponse;
use framework\message\Message;
use service\message\common\Header;
use service\models\common\CustomerException;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/25
 * Time: 11:02
 */
class Proxy
{
    protected static $client = [];
    protected static $ip = '172.16.10.203';
    protected static $port = 9091;
    const KEY_REDIS_ROUTE_TABLE_NAME = 'route_table';
    const ROUTE_ROUTE_FETCH = 'route.fetch';
    protected static function initRoutes()
    {
        $request = new FetchRouteRequest();
        $request->setAuthToken('yggBfivOTkMOFNDm');
        $message = self::sendRequest('route.fetch', $request);
        if ($message->getHeader()->getCode() > 0) {
            throw new CustomerException($message->getHeader()->getMsg(), $message->getHeader()->getCode());
        }
        /** @var FetchRouteResponse $response */
        $response = FetchRouteResponse::parseFromString($message->getPackageBody());
        $redis = Redis::getRedis();
        $data = [];
        foreach ($response->getServices() as $service) {
            /** @var \service\message\common\Service $service */
            $data[$service->getModule()] = serialize([$service->getIp(), $service->getPort()]);
        }
        if(count($data)>0){
            $redis->hMSet(self::KEY_REDIS_ROUTE_TABLE_NAME, $data);
            $redis->expire(self::KEY_REDIS_ROUTE_TABLE_NAME,60);
        }
    }

    /**
     * @param $route
     * @return array|bool|mixed|null|string
     * @throws CustomerException
     */
    public static function getRoute($route)
    {
        $parts = explode('.', $route);
        if (count($parts) != 2) {
            CustomerException::systemNotFound();
        }
        $modelName = $parts[0];
        if ($route == self::ROUTE_ROUTE_FETCH) {
            return [self::$ip, self::$port];
        }
        $redis = Redis::getRedis();
        if ($redis->hExist(self::KEY_REDIS_ROUTE_TABLE_NAME, $modelName)) {
            $data = $redis->hGet(self::KEY_REDIS_ROUTE_TABLE_NAME, $modelName);
        } else {
            self::initRoutes();
            $data = Redis::getRedis()->hGet(self::KEY_REDIS_ROUTE_TABLE_NAME, $modelName);
        }
        $data = unserialize($data);
        if (count($data) != 2) {
            CustomerException::systemNotFound();
        }
        return $data;
    }

    /**
     * Function: initHeader
     * Author: Jason Y. Wang
     *
     * @param $route
     * @return Header
     */
    protected static function initHeader($route){
        if($route){
            $header = new Header();
            $header->setVersion(1);
            $header->setRoute($route);
            $header->setEncrypt('des');
            $header->setProtocol('pb');
            return $header;
        }else{
            return null;
        }
    }

    /**
     * @param String $route
     * @param $request
     * @return Message
     * @throws CustomerException
     */
    public static function sendRequest($route, $request)
    {
        print_r($route);
        list($ip, $port) = self::getRoute($route);
        $client = self::getClient($ip, $port);
        $header = self::initHeader($route);
        $client->send(Message::pack($header, $request));
        $result = $client->recv();
        $message = new Message();
        $message->unpackResponse($result);
        if ($message->getHeader()->getCode() > 0) {
            throw new CustomerException($message->getHeader()->getMsg(), $message->getHeader()->getCode());
        }
        return $message;
    }

    /**
     * @param $ip
     * @param $port
     * @return \swoole_client
     * @throws CustomerException
     */
    protected static function getClient($ip, $port)
    {
        $key = sprintf('%s_%s', $ip, $port);
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect($ip, $port)) {
            throw new CustomerException(sprintf("connect failed. Error: %s", $client->errCode));
        }
        return $client;
    }
}