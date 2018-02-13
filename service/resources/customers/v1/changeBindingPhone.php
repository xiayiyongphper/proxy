<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 15:45
 */

namespace service\resources\customers\v1;

use common\components\CustomerSms;
use common\models\VerifyCode;
use service\message\customer\ChangeBindingPhoneRequest;
use service\models\common\Customer;
use common\models\LeCustomers;
use service\models\common\CustomerException;


class changeBindingPhone extends Customer
{

    /**
     * Function: run
     * Author: Jason Y. Wang
     *
     * @param \ProtocolBuffers\Message $data
     * @return mixed|void
     * @throws CustomerException
     */
    public function run($data){
        /** @var ChangeBindingPhoneRequest $request */
        $request = ChangeBindingPhoneRequest::parseFromString($data);
        /* @var LeCustomers $customer */
        $customer = $this->getCustomerModel($request->getCustomerId(),$request->getAuthToken());
        if($customer) {
            /** @var VerifyCode $verify */
            $verify = VerifyCode::find()
                ->where(['phone' => $request->getPhone(), 'verify_type' => CustomerSms::SMS_TYPE_CHANGE_BINDING_PHONE])
                ->orderBy(['created_at' => SORT_DESC])
                ->one();
            if ($verify && $verify['code'] == $request->getCode()) {
                $customer->phone = $request->getPhone();
                if ($customer->save()) {
                    $response = $this->getCustomerInfo($customer);
                    return $response;
                }else{
                    CustomerException::changeBindingPhoneError();
                }
            } else {
                CustomerException::verifyCodeError();
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