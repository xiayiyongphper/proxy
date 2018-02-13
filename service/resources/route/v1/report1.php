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
use service\message\common\Server;
use service\message\common\Service;
use service\message\core\ReportRouteRequest;
use service\resources\Exception;
use service\resources\ResourceAbstract;

class report1 extends ResourceAbstract
{
    protected $mapping;
    const LOCAL = 0b01;
    const REMOTE = 0b10;

    public function run($data)
    {
        /** @var ReportRouteRequest $request */
        $request = ReportRouteRequest::parseFromString($data);
        if ($request->getAuthToken() != 'yggBfivOTkMOFNDm') {
            Exception::invalidAuthToken();
        }
        ToolsAbstract::log($request->jsonSerialize());
        if (!$this->validateNodeService($request)) {
            return false;
        }
        $redis = ToolsAbstract::getRedis();
        $ip = $request->getServer()->getIp();
        $identifier = $this->getIdentifier($request->getServer());
        /**ip对应的节点列表**/
        $redis->sAdd($ip, $identifier);
        /**所有的ip的集合，取服务器ping值时用到**/
        $redis->hIncrBy(ProxyAbstract::SERVER_IP_SET, $ip, 1);
        /**把一类系统的节点列表的权重放在一张表（类如：core1:12;core2:5;core3:7）用于调度决策。**/
        $redis->hSet(ProxyAbstract::SERVICE_PREFIX . $this->getSourceCode(), $identifier, $this->calcWeight($request->getServer()));

        $localService = $request->getLocalService();
        $localServiceArray = [];
        foreach ($localService as $_localService) {
            /** @var Service $_localService */
            $localServiceArray[$_localService->getModule()] = $_localService->getIp() . ':' . $_localService->getPort();
        }
        if (count($localServiceArray) > 0) {
            $redis->hMset(ProxyAbstract::KEY_LOCAL_SERVICE . '_' . $identifier, $localServiceArray);
        }
        $remoteService = $request->getRemoteService();
        $remoteServiceArray = [];
        foreach ($remoteService as $_remoteService) {
            /** @var Service $_remoteService */
            $remoteServiceArray[$_remoteService->getModule()] = $_remoteService->getIp() . ':' . $_remoteService->getPort();
        }
        if (count($remoteServiceArray) > 0) {
            $redis->hMset(ProxyAbstract::KEY_REMOTE_SERVICE . '_' . $identifier, $remoteServiceArray);
        }
    }

    /**
     * @param ReportRouteRequest $request
     * @return boolean
     */
    public function validateNodeService($request)
    {
        $services = [];
        foreach ($request->getLocalService() as $_localService) {
            /** @var Service $_localService */
            if (!isset($services[$_localService->getModule()])) {
                $services[$_localService->getModule()] = self::LOCAL;
            } else {
                $services[$_localService->getModule()] |= self::LOCAL;
            }

        }
        foreach ($request->getRemoteService() as $_remoteService) {
            /** @var Service $_remoteService */
            if (!isset($services[$_remoteService->getModule()])) {
                $services[$_remoteService->getModule()] = self::REMOTE;
            } else {
                $services[$_remoteService->getModule()] |= self::REMOTE;
            }
        }
        $mapping = Wrr::getMapping();
        if (!isset($mapping[$this->getSource()])) {
            return false;
        }
        $rules = $mapping[$this->getSource()];
        $passed = true;
        foreach ($rules as $module => $value) {
            if (isset($services[$module]) && $services[$module] == $value) {
                continue;
            } else {
                $passed = false;
                break;
            }
        }
        return $passed;
    }


    /**
     * @param Server $server
     * @return string
     */
    protected function getIdentifier($server)
    {
        return sprintf('%s_%s', $this->getSourceCode(), $server->getIp());
    }

    /**
     * @param Server $server
     * @return float
     */
    protected function calcWeight($server)
    {
        $loads = $server->getLoads();
        $cores = $server->getCores();
        if (count($loads) >= 2) {
            $load = $loads[1];
        } elseif (count($loads) == 1) {
            $load = $loads[0];
        } else {
            $load = 1;
        }
        return $cores / $load;
    }

    public static function request()
    {
        return new ReportRouteRequest();
    }

    public static function response()
    {
        return false;
    }
}