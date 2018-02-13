<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 16:51
 */

namespace service\resources\customers\v1;


use common\models\LeCustomers;
use Exception;
use service\components\Tools;
use service\message\customer\CustomerAuthenticationRequest;
use service\message\customer\CustomerResponse;
use service\models\common\Customer;
use service\models\common\CustomerException;

class customerAuthentication extends Customer
{

    /**
     * Function: run
     * Author: Jason Y. Wang
     *
     * @param $data
     * @return \service\message\customer\CustomerResponse
     * @throws Exception
     */
    public function run($data){
        /** @var CustomerAuthenticationRequest $request */
        $request = CustomerAuthenticationRequest::parseFromString($data);

		// 为真则强制走数据库不取缓存数据
		$no_cache = $request->getNoCache();

        if(!$no_cache && $customerArray = Tools::getRedis()->hGet(LeCustomers::CUSTOMERS_INFO_COLLECTION,$request->getCustomerId())) {
            $customerArray = unserialize($customerArray);
            if($customerArray['auth_token'] == $request->getAuthToken()){
                $response = $this->getCustomerBriefInfo($customerArray);
                if(!empty($response->getProvince()) && !empty($response->getCity())){
                    return $response;
                }
            }
        }

        $customer = $this->getCustomerModel($request->getCustomerId(),$request->getAuthToken());
        //加入省市验证
        if(empty($customer->province) || empty($customer->city)){
            CustomerException::customerInfoEmpty();
        }
        if($customer){
            Tools::getRedis()->hSet(LeCustomers::CUSTOMERS_INFO_COLLECTION,$request->getCustomerId(),serialize($customer->toArray()));
            $response = $this->getCustomerBriefInfo($customer->toArray());
            //Tools::log($response,'wangyang.log');
            return $response;
        }
        CustomerException::customerNotExist();

    }

    public static function request(){
        return new CustomerAuthenticationRequest();
    }

    public static function response(){
        return new CustomerResponse();
    }

}