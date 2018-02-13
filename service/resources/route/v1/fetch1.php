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
use framework\wrr\Wrr;
use service\message\core\FetchRouteRequest;
use service\message\core\FetchRouteResponse;
use service\resources\Exception;
use service\resources\ResourceAbstract;

class fetch1 extends ResourceAbstract
{

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
        $services = [];
        $modules = ['core', 'merchant', 'customer'];
        foreach ($modules as $module) {
            $node = Wrr::dispatch($module);//调度，获取调度到的节点。
            ToolsAbstract::log($node, 'fetch1.log');
            if ($node && isset($node['provider'])) {
                $nodeServices = $this->prepareNodeService($node);
                $services = array_merge($services, $nodeServices);
            }
        }
        $response->setFrom(ToolsAbstract::pb_array_filter(['services' => $services]));
        ToolsAbstract::log($response->toArray(), 'route.fetch.log');
        return $response;
    }

    protected function prepareNodeService($node)
    {
        $services = [];
        $redis = ToolsAbstract::getRedis();
        $key = ProxyAbstract::KEY_LOCAL_SERVICE;
        if ($this->isRemote()) {
            $key = ProxyAbstract::KEY_REMOTE_SERVICE;
        }
        $key .= '_' . $node['provider'];
        $serviceMapping = $redis->hGetAll($key);
        foreach ($serviceMapping as $module => $dsn) {
            list($ip, $port) = explode(':', $dsn);
            $services[] = [
                'module' => $module,
                'ip' => $ip,
                'port' => $port,
            ];
        }
        return $services;
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