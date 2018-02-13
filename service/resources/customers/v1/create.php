<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 11:59
 */
namespace service\resources\customers\v1;
use common\components\CustomerSms;
use common\components\UserTools;
use common\models\LeCustomers;
use common\models\VerifyCode;
use framework\components\Security;
use service\components\Tools;
use service\message\customer\CustomerResponse;
use service\message\customer\RegisterRequest;
use service\models\common\Customer;
use service\models\common\CustomerException;
use service\models\customer\Observer;

class create extends Customer
{
    /**
     * Function: run
     * Author: Jason Y. Wang
     *
     * @param $data
     * @return \service\message\customer\CustomerResponse
     * @throws CustomerException
     */
    public function run($data){
        /** @var RegisterRequest $request */
        $request = RegisterRequest::parseFromString($data);
        /** @var CustomerResponse $response */
        $response = false;
        //判断验证码是否正确
        /** @var VerifyCode $verify */
        $verify = VerifyCode::find()
            ->where(['phone' => $request->getPhone(), 'verify_type' => CustomerSms::SMS_TYPE_REGISTER])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();
        //用户名不能为纯数字
        if(is_numeric($request->getUsername())){
            CustomerException::customerRegisterUsernameNumeric();
        }
        if ($verify && $verify['code'] == $request->getCode()) {
            if($request->getUsername() != '' && LeCustomers::checkUserByUserName($request->getUsername())){
                CustomerException::customerUsernameAlreadyRegistered();
            }
            if(LeCustomers::checkUserByPhone($request->getPhone())){
                CustomerException::customerPhoneAlreadyRegistered();
            }
            /* @var LeCustomers $customer */
            $customer = new LeCustomers();
            $customer->username = $request->getUsername();
            $customer->phone = $request->getPhone();
            $customer->password = Security::passwordHash($request->getPassword());
            $customer->auth_token = UserTools::getRandomString(16);
            $customer->created_at = date('Y-m-d H:i:s');
            $customer->updated_at = date('Y-m-d H:i:s');
            if($customer->save()){
                $response = $this->getCustomerInfo($customer);
            }else{
                Tools::logException(print_r($customer->errors,true));
                CustomerException::customerRegisterFailed();
            }
        } else {
            CustomerException::verifyCodeError();
        }
        return $response;
    }

    public static function request()
    {
    	return new RegisterRequest();
    }

    public static function response()
    {
    	return new CustomerResponse();
    }
}