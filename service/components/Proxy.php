<?php
namespace service\components;

use service\message\common\Header;
use service\message\common\SourceEnum;
use service\message\common\Store;
use service\message\core\FetchRouteRequest;
use service\message\core\FetchRouteResponse;
use service\message\core\ReportRouteRequest;
use service\message\merchant\getProductRequest;
use service\message\merchant\getProductResponse;
use service\message\merchant\getStoreDetailRequest;
use framework\message\Message;
use service\resources\Exception;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/25
 * Time: 11:02
 */
class Proxy
{
    const KEY_REDIS_ROUTE_TABLE_NAME = 'route_table';
    const KEY_REDIS_LOCAL_ROUTE_TABLE_NAME = 'local_route_table';
    const ROUTE_ROUTE_FETCH = 'route.fetch';
    const ROUTE_ROUTE_REPORT = 'route.report';
    const ROUTE_MERCHANT_GET_STORE_DETAIL = 'merchant.getStoreDetail';
    const ROUTE_MERCHANT_GET_PRODUCT = 'merchant.getProduct';
    const ROUTE_FETCH_TOKEN = 'yggBfivOTkMOFNDm';
    const LOCAL = 'local';
    const REMOTE = 'remote';
    protected static $client = [];

    /**
     * @param $route
     * @param bool|false $remote
     * @param string $environment
     * @return array|bool|mixed|null|string
     * @throws \Exception
     */
    public static function getRoute($route,$remote=false,$environment='product')
    {
        $parts = explode('.', $route);
        if (count($parts) != 2) {
            Exception::systemNotFound();
        }
        $modelName = $parts[0];
        if ($route == self::ROUTE_ROUTE_FETCH || $route == self::ROUTE_ROUTE_REPORT) {
            $ipPort = \Yii::$app->params['proxy'][$environment];
            if (!is_array($ipPort)) {
                throw new \Exception('ip port config not found');
            }
            $host = $ipPort['host'];
            $port = $ipPort['port'];
            $localHost = $ipPort['localHost'];
            $localPort = $ipPort['localPort'];
            return $remote?[$host, $port]:[$localHost, $localPort];
        }
        $redis = Tools::getRedis();
        $tableName = self::KEY_REDIS_LOCAL_ROUTE_TABLE_NAME;
        if($remote){
            $tableName = self::KEY_REDIS_ROUTE_TABLE_NAME;
        }
        if ($redis->hExists($tableName, $modelName)) {
            $data = $redis->hGet($tableName, $modelName);
        } else {
            self::initRoutes($remote);
            $data = $redis->hGet($tableName, $modelName);
        }
        $data = unserialize($data);
        if (count($data) != 2) {
            Exception::systemNotFound();
        }

        return $data;
    }

    protected static function initRoutes($remote)
    {
        $request = new FetchRouteRequest();
        $request->setAuthToken(self::ROUTE_FETCH_TOKEN);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute(self::ROUTE_ROUTE_FETCH);
        $message = self::sendRequest($header, $request,$remote);
        if ($message->getHeader()->getCode() > 0) {
            throw new \Exception($message->getHeader()->getMsg(), $message->getHeader()->getCode());
        }
        /** @var FetchRouteResponse $response */
        $response = FetchRouteResponse::parseFromString($message->getPackageBody());
        $redis = Tools::getRedis();
        $data = [];
        foreach ($response->getServices() as $service) {
            /** @var \service\message\common\Service $service */
            $data[$service->getModule()] = serialize([$service->getIp(), $service->getPort()]);
        }
        $tableName = self::KEY_REDIS_LOCAL_ROUTE_TABLE_NAME;
        if($remote){
            $tableName = self::KEY_REDIS_ROUTE_TABLE_NAME;
        }
        if (count($data) > 0) {
            $redis->hMSet($tableName, $data);
            $redis->expire($tableName, 60);
        }
    }

    /**
     * @param Header $header
     * @param $request
     * @param bool|false $remote
     * @param string $environment
     * @return Message
     * @throws \Exception
     */
    public static function sendRequest($header, $request,$remote=false,$environment='product')
    {
        list($ip, $port) = self::getRoute($header->getRoute(),$remote,$environment);
        $client = self::getClient($ip, $port);
        $client->send(Message::pack($header, $request));
        $result = $client->recv();
        // swoole 1.8.1有bug,close之后此task也退出了. https://github.com/swoole/swoole-src/issues/522
        //$client->close();
        $message = new Message();
        $message->unpackResponse($result);
        if ($message->getHeader()->getCode() > 0) {
            $e = new \Exception($message->getHeader()->getMsg(), $message->getHeader()->getCode());
            Tools::logException($e);
            throw $e;
        }
        return $message;
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
        Tools::log(__METHOD__);
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        // 加上跟SOAClient一样的结束符检测
        $client->set(array(
            'open_length_check'     => 1,
            'package_length_type'   => 'N',
            'package_length_offset' => 0,       //第N个字节是包长度的值
            'package_body_offset'   => 4,       //第几个字节开始计算长度
            'package_max_length'    => 2000000,  //协议最大长度
            'socket_buffer_size'    => 1024 * 1024 * 2, //2M缓存区
        ));
        $ret = $client->connect($ip, $port, 1);
        if (!$ret) {
            $e = new \Exception(sprintf("connect failed. Error: %s", $client->errCode));
            Tools::logException($e);
            throw $e;
        }
        $sockName = $client->getsockname();
        Tools::log("[Server]: New Proxy Client:[{$sockName['host']}:{$sockName['port']}]<->to:{$ip}:[{$port}]");
        return $client;
    }

    /**
     * @param $wholesalerId
     * @param $traceId
     *
     * @return Store
     * @throws \Exception
     */
    public static function getWholesaler($wholesalerId, $traceId)
    {
        $request = new getStoreDetailRequest();
        $request->setWholesalerId($wholesalerId);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute(self::ROUTE_MERCHANT_GET_STORE_DETAIL);
        $header->setTraceId($traceId);
        $message = self::sendRequest($header, $request);
        $response = Store::parseFromString($message->getPackageBody());
        return $response;
    }

    public static function getRelatedWholesalers()
    {

    }

    /**
     * @param $wholesalerId
     * @param $productId
     *
     * @return bool|getProductResponse
     * @throws \Exception
     */
    public static function getProducts($wholesalerId, $productId, $traceId)
    {
        if (!$wholesalerId || !is_array($productId) || count($productId) == 0) {
            return false;
        }

        $requestData = [
            'wholesaler_id' => $wholesalerId,
            'product_ids' => $productId,
        ];
        $request = new getProductRequest();
        $request->setFrom($requestData);
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute(self::ROUTE_MERCHANT_GET_PRODUCT);
        $header->setTraceId($traceId);
        $message = self::sendRequest($header, $request);
        /** @var getProductResponse $response */
        $response = getProductResponse::parseFromString($message->getPackageBody());

        return $response;
    }

    public static function reportServices($serviceMapping,$remote=false){
        $request = new ReportRouteRequest();
        $requestData = [];
        foreach($serviceMapping as $key=>$services){
            switch($key){
                case self::LOCAL:
                    $requestData['local_service'] = $services;
                    break;
                case self::REMOTE:
                    $requestData['remote_service'] = $services;
                    break;
                default:

            }
        }
        if(count($requestData)>0){
            $requestData['auth_token'] = self::ROUTE_FETCH_TOKEN;
            $request->setFrom($requestData);
            $header = new Header();
            $header->setSource(SourceEnum::MERCHANT);
            $header->setRoute(self::ROUTE_ROUTE_REPORT);
            self::sendRequest($header,$request,$remote);
        }
    }

    public static function reportSyncProcessResult($data){
        //data.notification
        $response = new \service\message\syncProcess\ProcessResponse();
        $response->setFrom(array_filter($data));
        $header = new Header();
        $header->setSource(SourceEnum::MERCHANT);
        $header->setRoute('data.notification');
        // 发送
        try{
            $reportResponse = self::sendRequest($header,$response,false);
            return true;
        }catch(\Exception $e){
            return false;
        }

    }
}