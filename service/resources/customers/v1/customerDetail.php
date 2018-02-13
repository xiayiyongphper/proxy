<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 15:42
 */

namespace service\resources\customers\v1;


use common\models\LeCustomers;
use Exception;
use service\message\customer\CustomerDetailRequest;
use service\message\customer\CustomerResponse;
use service\models\common\Customer;
use service\models\common\CustomerException;

class customerDetail extends Customer
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
        /** @var CustomerDetailRequest $request */
        $request = CustomerDetailRequest::parseFromString($data);
        /* @var LeCustomers $customer */
        $customer = $this->getCustomerModel($request->getCustomerId(),$request->getAuthToken());
        if($customer){
            $response = $this->getCustomerInfo($customer);
            return $response;
        }else{
            CustomerException::customerAuthTokenExpired();
        }
    }

    public static function request(){
        return new CustomerDetailRequest();
    }

    public static function response(){
        return new CustomerResponse();
    }
}