<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 16:20
 */

namespace service\resources\customers\v1;


use common\models\LeCustomers;
use common\models\LeCustomersAddressBook;
use Exception;
use service\message\customer\ChangeReceiverInfoRequest;
use service\models\common\Customer;
use service\models\common\CustomerException;

class changeReceiverInfo extends Customer
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
        /** @var ChangeReceiverInfoRequest $request */
        $request = ChangeReceiverInfoRequest::parseFromString($data);
        /* @var LeCustomers $customer */
        $customer = $this->getCustomerModel($request->getCustomerId(),$request->getAuthToken());
        if($customer){
            //保存收货人信息
            /* @var $addressBook LeCustomersAddressBook */
            $addressBook = new LeCustomersAddressBook();
            $addressBook = $addressBook->findReceiverCustomerId($customer->getId());
            if($addressBook){
                $addressBook->receiver_name = $request->getReceiverName();
                $addressBook->phone = $request->getReceiverPhone();
                $addressBook->updated_at = date('Y-m-d H:i:s');
                $addressBook->save();
            }else{
                $addressBook = new LeCustomersAddressBook();
                $addressBook->customer_id = $customer->entity_id;
                $addressBook->receiver_name = $request->getReceiverName();
                $addressBook->phone = $request->getReceiverPhone();
                $addressBook->created_at = date('Y-m-d H:i:s');
                $addressBook->updated_at = date('Y-m-d H:i:s');
                $addressBook->save();
            }
            $response = $this->getCustomerInfo($customer);
            return $response;
        }else{
            CustomerException::customerAuthTokenExpired();
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