<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 18:31
 */
namespace service\resources\route\v1;

use framework\components\ProxyAbstract;
use framework\components\ToolsAbstract;
use service\message\common\KeyValueItem;
use service\message\common\Service;
use service\message\common\SourceEnum;
use service\message\core\FetchRouteRequest;
use service\message\core\FetchRouteResponse;
use service\resources\Exception;
use service\resources\ResourceAbstract;

class fetch extends ResourceAbstract
{
    protected $_mapping = [
        '121.201.110.245' => 'n2.lelai.com',
        '121.201.110.86' => 'n1.lelai.com',
        '121.201.109.95' => 'n3.lelai.com'
    ];
    protected $_shortTcp = [
        SourceEnum::IOS_SHOP => '2.4.0',
        SourceEnum::IOS_DRIVER => '1.0.0',
    ];

    /**
     * @param \ProtocolBuffers\Message $data
     * @return FetchRouteResponse
     * @throws \Exception
     */
    public function run($data)
    {
        ToolsAbstract::log($data, 'fetch.log');
        /** @var FetchRouteRequest $request */
        $request = FetchRouteRequest::parseFromString($data);
        ToolsAbstract::log($request->toArray(), 'fetch.log');
        if ($request->getAuthToken() != 'yggBfivOTkMOFNDm') {
            Exception::invalidAuthToken();
        }
        $response = new FetchRouteResponse();
        $redis = ToolsAbstract::getRedis();
        $key = ProxyAbstract::KEY_LOCAL_SERVICE;
        if ($this->isRemote()) {
            $key = ProxyAbstract::KEY_REMOTE_SERVICE;
        }
        $serviceMapping = $redis->hGetAll($key);
        $mapping = $this->getMapping();
        foreach ($serviceMapping as $module => $dsn) {
            list($ip, $port) = explode(':', $dsn);
            $service = new Service();
            $service->setModule($module);
            if (is_array($mapping) && isset($mapping[$ip])) {
                $service->setIp($mapping[$ip]);
            } else {
                $service->setIp($ip);
            }
            $service->setPort($port);
            $response->appendServices($service);
        }
        foreach ($this->_mapping as $ip => $host) {
            $map = new KeyValueItem();
            $map->setKey($ip);
            $map->setValue($host);
            $response->appendMapping($map);
        }

        /**
         * if (isset($this->_shortTcp[$this->getSource()]) && version_compare($this->getAppVersion(), $this->_shortTcp[$this->getSource()], '>=')) {
            $response->setShortTcp(true);
        }*/
        ToolsAbstract::log($response->toArray(), 'route.fetch.log');
        return $response;
    }

    /**
     * @return bool
     */
    public function getMapping()
    {
        $mapping = false;
        if ($this->isRemote()) {
            $mapping = $this->_mapping;
        }
        return $mapping;
    }

    public static function request()
    {
        return new FetchRouteRequest();
    }

    public static function response()
    {
        return new FetchRouteResponse();
    }
}