<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 14:32
 */

namespace service\resources\customers\v1;


use common\models\LeCustomers;
use service\message\customer\FillCustomerInfoRequest;
use service\models\common\CustomerException;
use yii\base\Exception;
use service\models\common\Customer;

class changeCustomerInfo extends Customer
{

    /**
     * Function: run
     * Author: Jason Y. Wang
     * 保存用户信息
     * @param $data
     * @return \service\message\customer\CustomerResponse
     * @throws Exception
     */
    public function run($data){
        /** @var FillCustomerInfoRequest $request */
        $request = FillCustomerInfoRequest::parseFromString($data);
        /* @var LeCustomers $customer */
        $customer = $this->getCustomerModel($request->getCustomerId(),$request->getAuthToken());
        if($customer){
            $customer->store_name = $request->getStoreName();
            $customer->storekeeper = $request->getStoreKeeper();
            $customer->store_area = $request->getStoreArea();
            $customer->business_license_img = $request->getBusinessLicenseImg();
            $customer->updated_at = date('Y-m-d H:i:s');
            if($customer->save()){
                $response = $this->getCustomerInfo($customer);
                return $response;
            }else{
                CustomerException::customerSystemError();
            }
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