<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/25
 * Time: 11:31
 */

namespace service\resources\contractor\v1;

use common\components\ContractorSms;
use service\message\customer\GetSmsRequest;
use service\models\common\Contractor;
use service\models\common\ContractorException;

class sms extends Contractor
{
    /**
     * Function: run
     * Author: Jason Y. Wang
     *
     * @param $data
     * @return mixed
     */
    public function run($data)
    {
        /** @var GetSmsRequest $request */
        $request = GetSmsRequest::parseFromString($data);
        if ($request->getToken() == ContractorSms::SMS_TOKEN) {
            $result = ContractorSms::sendMessage($request);
            if($result){
                return true;
            }else{
                ContractorException::contractorCodeSendError();
            }
        } else {
            ContractorException::contractorAuthTokenExpired();
        }
    }

    public static function request(){
        return new GetSmsRequest();
    }

    public static function response(){
        return true;
    }
}