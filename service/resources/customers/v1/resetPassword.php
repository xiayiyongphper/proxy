<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/25
 * Time: 17:22
 */

namespace service\resources\customers\v1;


use common\components\CustomerSms;
use common\components\UserTools;
use common\models\LeCustomers;
use common\models\VerifyCode;
use framework\components\Security;
use service\components\Tools;
use service\message\common\SourceEnum;
use service\message\customer\ResetPasswordRequest;
use service\models\common\Customer;
use service\models\common\CustomerException;

class resetPassword extends Customer
{
    /**
     * Function: run
     * Author: Jason Y. Wang
     * 修改密码
     * @param $data
     * @return bool
     * @throws CustomerException
     */
    public function run($data)
    {
        /** @var ResetPasswordRequest $request */
        $request = ResetPasswordRequest::parseFromString($data);
        switch($request->getType()){
            case 1: //忘记密码
                $response = $this->forgetPassword($request);
                break;
            case 2:  //修改密码
                $response = $this->modifyPassword($request);
                break;
            default:
                CustomerException::customerSystemError();
                break;
        }
        return $response;
    }

    /**
     * Function: modifyPassword
     * Author: Jason Y. Wang
     * 修改密码，需要是登陆状态
     * @param ResetPasswordRequest $request
     * @return \service\message\customer\CustomerResponse
     * @throws CustomerException
     */
    public function modifyPassword(ResetPasswordRequest $request){
        /* @var LeCustomers $customer */
        $customer = $this->getCustomerModel($request->getCustomerId(),$request->getAuthToken());
        if($customer) {
            /** @var VerifyCode $verify */
            $verify = VerifyCode::find()
                ->where(['phone' => $request->getPhone(), 'verify_type' => CustomerSms::SMS_TYPE_FORGET])
                ->orderBy(['created_at' => SORT_DESC])
                ->one();
            if($this->getSource() == SourceEnum::ANDROID_CASH || $this->getSource() == SourceEnum::PCWEB){
                /** @var LeCustomers $customer */
                $customer = LeCustomers::findByCustomerId($request->getCustomerId());
                if($request->getOriginalPassword() && LeCustomers::verifyPassword($customer,$request->getOriginalPassword())){
                    $customer->password = Security::passwordHash($request->getNewPassword());
                    $customer->auth_token = UserTools::getRandomString(16);
                    if ($customer->save()) {
                        $response = $this->getCustomerInfo($customer);
                        return $response;
                    }else{
                        CustomerException::customerSystemError();
                    }
                }else{
                    CustomerException::customerOriginalPasswordError();
                }
            }else{
                if ($verify && $verify['code'] == $request->getCode()) {
                    /** @var LeCustomers $customer */
                    $customer = LeCustomers::findByCustomerId($request->getCustomerId());
                    $customer->password = Security::passwordHash($request->getNewPassword());
                    $customer->auth_token = UserTools::getRandomString(16);
                    if ($customer->save()) {
                        $response = $this->getCustomerInfo($customer);
                        return $response;
                    }else{
                        CustomerException::customerSystemError();
                    }
                } else {
                    CustomerException::verifyCodeError();
                }
            }
        }else{
            CustomerException::customerAuthTokenExpired();
        }
    }

    /**
     * Function: forgetPassword
     * Author: Jason Y. Wang
     * 忘记密码，不需要登陆
     * @param ResetPasswordRequest $request
     * @return LeCustomers
     * @throws CustomerException
     */
    public function forgetPassword(ResetPasswordRequest $request){
        /** @var VerifyCode $verify */
        $verify = VerifyCode::find()
            ->where(['phone' => $request->getPhone(),'verify_type' => CustomerSms::SMS_TYPE_FORGET ])
            ->orderBy(['created_at' => SORT_DESC ])
            ->one();
        if ($verify && $verify['code'] == $request->getCode()) {
            /** @var LeCustomers $customer */
            $customer = LeCustomers::findByPhone($request->getPhone());
            if($customer){
                $customer->password = Security::passwordHash($request->getNewPassword());
                $customer->auth_token = UserTools::getRandomString(16);
                if($customer->save()) {
                    $response = $this->getCustomerInfo($customer);
                    return $response;
                }else{
                    CustomerException::customerSystemError();
                }
            }else{
                CustomerException::customerPhoneNotRegistered();
            }
        } else {
            CustomerException::verifyCodeError();;
        }
    }

    public static function request()
    {
        // TODO: Implement request() method.
    }

    public static function response()
    {
        // TODO: Implement response() method.
    }


}