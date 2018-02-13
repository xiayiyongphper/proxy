<?php
namespace common\components;

use common\components\sms\SmsYp;
use common\components\sms\SmsYtx;
use common\models\LeCustomers;
use common\models\VerifyCode;
use service\message\customer\GetSmsRequest;
use service\models\common\CustomerException;

/**
 * Author: Jason Y. Wang
 * Class CustomerSms
 * @package common\components
 */
class CustomerSms
{
    //云通讯
    const SMS_CHANNEL_YTX = 1;
    //云片
    const SMS_CHANNEL_YP = 2;

    //注册
    const SMS_TYPE_REGISTER = 1;
    //忘记密码
    const SMS_TYPE_FORGET = 2;
    //快速登录
    const SMS_TYPE_LOGIN = 3;
    //收货码
    const SMS_TYPE_RECEIPT = 4;
    //微信退款通知
    const SMS_TYPE_REFUND = 5;
    //用户注册成功短信
    const SMS_TYPE_REGISTER_SUCCESS = 6;
    //修改用户绑定手机号
    const SMS_TYPE_CHANGE_BINDING_PHONE = 7;

    //发送短信token
    const SMS_TOKEN = '9gdgtq7eym0579dobesmqm5ze0ig3mpm';

    const XML_PATH_SMS_DEFAULT_CHANNEL = 'sms_config/general/default_channel';
    const XML_PATH_SMS_RESEND_INTERVAL = 'sms_config/general/resend_interval';

    /**
     * Function: sendMessage
     * Author: Jason Y. Wang
     *
     * @param GetSmsRequest $request
     * @throws CustomerException
     */
    public static function sendMessage(GetSmsRequest $request)
    {
        $voice = false;
        $type = 1;

        if (!preg_match('/1[34578]{1}\d{9}$/', $request->getPhone())) {
            CustomerException::customerPhoneInvalid();
        }
        switch ($request->getType()) {
            case 1:  //注册
                if (LeCustomers::findByPhone($request->getPhone())) {
                    CustomerException::customerPhoneAlreadyRegistered();
                }
                $type = CustomerSms::SMS_TYPE_REGISTER;
                $voice = false;
                break;
            case 2:  //忘记密码
                //验证手机有没有注册超市
                if (!LeCustomers::findByPhone($request->getPhone())) {
                    CustomerException::customerPhoneNotRegistered();
                }
                $type = CustomerSms::SMS_TYPE_FORGET;
                $voice = false;
                break;
            case 3:
                $type = CustomerSms::SMS_TYPE_LOGIN;
                $voice = false;
                break;
            case 7: //修改绑定手机号
                //验证手机有没有绑定超市
                if (LeCustomers::findByPhone($request->getPhone())) {
                    CustomerException::customerPhoneAlreadyBinding();
                }
                $type = CustomerSms::SMS_TYPE_CHANGE_BINDING_PHONE;
                $voice = false;
                break;
            case 11:
                if (LeCustomers::findByPhone($request->getPhone())) {
                    CustomerException::customerPhoneAlreadyRegistered();
                }
                $type = CustomerSms::SMS_TYPE_REGISTER;
                $voice = true;
                break;
            case 21:
                //验证手机有没有注册超市
                if (!LeCustomers::findByPhone($request->getPhone())) {
                    CustomerException::customerPhoneNotRegistered();
                }
                $type = CustomerSms::SMS_TYPE_FORGET;
                $voice = true;
                break;
            case 31:
                $type = CustomerSms::SMS_TYPE_LOGIN;
                $voice = true;
                break;
            case 71:
                //验证手机有没有绑定超市
                if (LeCustomers::findByPhone($request->getPhone())) {
                    CustomerException::customerPhoneAlreadyBinding();
                }
                $type = CustomerSms::SMS_TYPE_CHANGE_BINDING_PHONE;
                $voice = true;
                break;
            default:
                CustomerException::customerSmsTypeInvalid();
        }
        /** @var  VerifyCode $verify */
        $verify = VerifyCode::find()->where(['phone' => $request->getPhone(), 'verify_type' => $request->getType()])->orderBy(['created_at' => SORT_DESC])->one();
        if ($verify && strtotime($verify['created_at']) + 60 > time()) {
            throw new CustomerException('验证码已发送,60秒后可重新获取.', CustomerException::RESOURCE_NOT_FOUND);
        }else{
            $code = strrev(rand(1000, 9999));
            $verify = new VerifyCode();
            $verify->phone = $request->getPhone();
            $verify->code = $code;
            $verify->verify_type = $request->getType();
            $verify->created_at = date('Y-m-d H:i:s');
            $verify->count = 1;
            $verify->save();
            self::send($request->getPhone(), $type, array('code' => $code, 'minute' => 1), $voice);
        }
    }

    protected static function send($to, $type, $data, $voice = false, $channel = 2)
    {
        switch ($channel) {
            case self::SMS_CHANNEL_YTX:
                $sms = new SmsYtx();
                $data = array_values($data);
                break;
            case self::SMS_CHANNEL_YP:
            default:
                $sms = new SmsYp();
                break;
        }
        $result = $sms->send($to, $type, $data, $voice);
        return $result;
    }

}