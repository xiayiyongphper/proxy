<?php
namespace framework;
/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-26
 * Time: 下午4:19
 * Email: henryzxj1989@gmail.com
 */

/**
 * Class Exception
 * @package framework
 */
class Exception
{
    const DEFAULT_ERROR_CODE = 30001;//default error code, none exception
    const SERVICE_NOT_AVAILABLE = 30503;
    const SERVICE_NOT_AVAILABLE_TEXT = '系统错误，请稍后重试！';
    const SYSTEM_MAINTENANCE = 35003;
    const SYSTEM_MAINTENANCE_TEXT = '系统维护中，请稍后重试';
    const OFFLINE = 39999;
    const SYSTEM_NOT_FOUND = 30404;
    const SYSTEM_NOT_FOUND_TEXT = '找不到相关信息';
    const RESOURCE_NOT_FOUND_TEXT = '找不到相关资源';
    const RESOURCE_NOT_FOUND = 31001;
    const INVALID_REQUEST_ROUTE_TEXT = '非法的请求';
    const INVALID_REQUEST_ROUTE = 31002;

    public static function offline($text)
    {
        throw new \Exception($text, self::OFFLINE);
    }

    public static function resourceNotFound()
    {
        throw new \Exception(self::RESOURCE_NOT_FOUND_TEXT, self::RESOURCE_NOT_FOUND);
    }

    public static function invalidRequestRoute()
    {
        throw new \Exception(self::INVALID_REQUEST_ROUTE_TEXT, self::INVALID_REQUEST_ROUTE);
    }

    public static function systemNotFound()
    {
        throw new \Exception(self::SYSTEM_NOT_FOUND_TEXT, self::SYSTEM_NOT_FOUND);
    }

    public static function serviceNotAvailable()
    {
        throw new \Exception(self::SERVICE_NOT_AVAILABLE_TEXT, self::SERVICE_NOT_AVAILABLE);
    }

    public static function systemMaintenance()
    {
        throw new \Exception(self::SYSTEM_MAINTENANCE_TEXT, self::SYSTEM_MAINTENANCE);
    }

}
