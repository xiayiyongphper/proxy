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
use service\message\common\Service;
use service\message\core\ReportRouteRequest;
use service\resources\Exception;
use service\resources\ResourceAbstract;

class report extends ResourceAbstract
{
    /**
     * @param \ProtocolBuffers\Message $data
     * @throws \Exception
     */
    public function run($data)
    {
        /** @var ReportRouteRequest $request */
        $request = ReportRouteRequest::parseFromString($data);
        if ($request->getAuthToken() != 'yggBfivOTkMOFNDm') {
            Exception::invalidAuthToken();
        }
        ToolsAbstract::log($request->jsonSerialize());
        $redis = ToolsAbstract::getRedis();
        $localService = $request->getLocalService();
        $localServiceArray = [];
        foreach ($localService as $_localService) {
            /** @var Service $_localService */
            $localServiceArray[$_localService->getModule()] = $_localService->getIp() . ':' . $_localService->getPort();
        }
        if (count($localServiceArray) > 0) {
            $redis->hMset(ProxyAbstract::KEY_LOCAL_SERVICE, $localServiceArray);
        }
        $remoteService = $request->getRemoteService();
        $remoteServiceArray = [];
        foreach ($remoteService as $_remoteService) {
            /** @var Service $_remoteService */
            $remoteServiceArray[$_remoteService->getModule()] = $_remoteService->getIp() . ':' . $_remoteService->getPort();
        }
        if (count($remoteServiceArray) > 0) {
            $redis->hMset(ProxyAbstract::KEY_REMOTE_SERVICE, $remoteServiceArray);
        }
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