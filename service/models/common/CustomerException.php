<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/25
 * Time: 13:35
 */

namespace service\models\common;


use yii\base\Exception;

class CustomerException extends Exception
{
    const DEFAULT_ERROR_CODE = 0;//default error code, none exception
    const SERVICE_NOT_AVAILABLE = 503;
    const SERVICE_NOT_AVAILABLE_TEXT = '系统错误，请稍后重试！';
    const SYSTEM_MAINTENANCE = 5003;
    const SYSTEM_MAINTENANCE_TEXT = '系统维护中，请稍后重试';
    const SYSTEM_NOT_FOUND = 404;
    const SYSTEM_NOT_FOUND_TEXT = '找不到相关信息';
    const RESOURCE_NOT_FOUND = 1001;
    const RESOURCE_NOT_FOUND_TEXT = '找不到相关资源';
    const INVALID_REQUEST_ROUTE = 1002;
    const INVALID_REQUEST_ROUTE_TEXT = '非法的请求';

    /**
     * customer not found
     */
    const CUSTOMER_NOT_FOUND = 2001;
    const CUSTOMER_NOT_FOUND_TEXT = '用户不存在';
    /**
     * customer auth token expired
     */
    const CUSTOMER_AUTH_TOKEN_EXPIRED = 2002;
    const CUSTOMER_AUTH_TOKEN_EXPIRED_TEXT = '用户信息已过期，请重新登陆！';
    const CUSTOMER_SHOPPING_CART_EMPTY = 2003;
    const CUSTOMER_SHOPPING_CART_EMPTY_TEXT = '购物车为空，请先添加商品！';
    const CUSTOMER_PHONE_INVALID = 2004;
    const CUSTOMER_PHONE_INVALID_TEXT = '手机号码有误！';
    const CUSTOMER_PHONE_ALREADY_REGISTERED = 2005;
    const CUSTOMER_PHONE_ALREADY_REGISTERED_TEXT = '该手机号码已注册！';
    const CUSTOMER_PHONE_NOT_REGISTERED = 2006;
    const CUSTOMER_PHONE_NOT_REGISTERED_TEXT = '该手机号码未注册！';
    const CUSTOMER_USERNAME_ALREADY_REGISTERED = 2007;
    const CUSTOMER_USERNAME_ALREADY_REGISTERED_TEXT = '该用户名已注册！';
    const CUSTOMER_PHONE_ALREADY_BINDING = 2008;
    const CUSTOMER_PHONE_ALREADY_BINDING_TEXT = '该手机号码已被绑定！';
    const CUSTOMER_SMS_TYPE_INVALID = 2009;
    const CUSTOMER_SMS_TYPE_INVALID_TEXT = '短信验证码类型错误!';
    const CUSTOMER_REGISTER_FAILED = 2010;
    const CUSTOMER_REGISTER_FAILED_TEXT = '注册失败!';
    const VERIFY_CODE_ERROR = 2011;
    const VERIFY_CODE_ERROR_TEXT = '验证码错误!';
    const CUSTOMER_REGISTER_NUMERIC = 2012;
    const CUSTOMER_REGISTER_NUMERIC_TEXT = '用户名不能为数字!';
    const CHANGE_BANDING_PHONE_ERROR = 2013;
    const CHANGE_BANDING_PHONE_ERROR_TEXT = '修改绑定手机失败!';
    const VERIFY_CODE_EXPIRED = 2014;
    const VERIFY_CODE_EXPIRED_TEXT = '验证码已过期';


    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }

    public static function resourceNotFound()
    {
        throw new CustomerException(self::RESOURCE_NOT_FOUND_TEXT, self::RESOURCE_NOT_FOUND);
    }

    public static function customerPhoneInvalid()
    {
        throw new CustomerException(self::CUSTOMER_PHONE_INVALID_TEXT, self::CUSTOMER_PHONE_INVALID);
    }

    public static function customerPhoneAlreadyRegistered()
    {
        throw new CustomerException(self::CUSTOMER_PHONE_ALREADY_REGISTERED_TEXT, self::CUSTOMER_PHONE_ALREADY_REGISTERED);
    }

    public static function customerUsernameAlreadyRegistered()
    {
        throw new CustomerException(self::CUSTOMER_USERNAME_ALREADY_REGISTERED_TEXT, self::CUSTOMER_USERNAME_ALREADY_REGISTERED);
    }

    public static function customerPhoneNotRegistered()
    {
        throw new CustomerException(self::CUSTOMER_PHONE_NOT_REGISTERED_TEXT, self::CUSTOMER_PHONE_NOT_REGISTERED);
    }

    public static function customerPhoneAlreadyBinding()
    {
        throw new CustomerException(self::CUSTOMER_PHONE_ALREADY_BINDING_TEXT, self::CUSTOMER_PHONE_ALREADY_BINDING);
    }

    public static function customerSmsTypeInvalid()
    {
        throw new CustomerException(self::CUSTOMER_SMS_TYPE_INVALID_TEXT, self::CUSTOMER_SMS_TYPE_INVALID);
    }

    public static function systemNotFound()
    {
        throw new CustomerException(self::SYSTEM_NOT_FOUND_TEXT, self::SYSTEM_NOT_FOUND);
    }

    public static function customerAuthTokenExpired()
    {
        throw new CustomerException(self::CUSTOMER_AUTH_TOKEN_EXPIRED_TEXT, self::CUSTOMER_AUTH_TOKEN_EXPIRED);
    }

    public static function customerRegisterFailed()
    {
        throw new CustomerException(self::CUSTOMER_REGISTER_FAILED_TEXT, self::CUSTOMER_REGISTER_FAILED);
    }

    public static function customerRegisterUsernameNumeric()
    {
        throw new CustomerException(self::CUSTOMER_REGISTER_NUMERIC_TEXT, self::CUSTOMER_REGISTER_NUMERIC);
    }

    public static function verifyCodeError()
    {
        throw new CustomerException(self::VERIFY_CODE_ERROR_TEXT, self::VERIFY_CODE_ERROR);
    }

    public static function verifyCodeExpired()
    {
        throw new CustomerException(self::VERIFY_CODE_EXPIRED_TEXT, self::VERIFY_CODE_EXPIRED);
    }

    public static function invalidRequestRoute()
    {
        throw new CustomerException(self::INVALID_REQUEST_ROUTE_TEXT, self::INVALID_REQUEST_ROUTE);
    }

    public static function changeBindingPhoneError()
    {
        throw new CustomerException(self::CHANGE_BANDING_PHONE_ERROR_TEXT, self::CHANGE_BANDING_PHONE_ERROR);
    }

}