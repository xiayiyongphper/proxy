<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 18:31
 */
namespace service\resources\customers\v1;

use common\components\UserTools;
use common\models\LeCustomers;
use service\components\Tools;
use service\message\customer\CustomerResponse;
use service\message\customer\LoginRequest;
use service\models\common\CustomerException;
use yii\base\Exception;
use service\models\common\Customer;

class login extends Customer
{
    /**
     * Function: run
     * Author: Jason Y. Wang
     *
     * @param $data
     * @return CustomerResponse
     * @throws Exception
     */
    public function run($data)
    {
        $startTime = microtime(true);
        /** @var LoginRequest $request */
        $request = LoginRequest::parseFromString($data);
        if(empty($request->getUsername())){
            CustomerException::customerNotExist();
        }
        if(!LeCustomers::checkUsername($request->getUsername())){
            CustomerException::customerNotExist();
        }
        /* @var LeCustomers $customer */
        $customer = LeCustomers::findByUsername($request->getUsername(), $request->getPassword());
        $endTime = microtime(true);
        Tools::log('=====================','wangyang.log');
        Tools::log($endTime-$startTime,'wangyang.log');

        if(!$customer){
            CustomerException::customerPasswordError();
        }

        //不重新生成auth_token,不互踢
        if(!$customer->auth_token){
            $customer->auth_token = UserTools::getRandomString(16);
            $customer->save();
        }
        $response = $this->getCustomerInfo($customer);
        //重新登录后刷新缓存
        Tools::getRedis()->hDel(LeCustomers::CUSTOMERS_INFO_COLLECTION,$customer->entity_id);
        return $response;
    }

    public static function request(){
        return new LoginRequest();
    }

    public static function response(){
        return new CustomerResponse();
    }

}