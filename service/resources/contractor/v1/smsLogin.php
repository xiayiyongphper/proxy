<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 18:31
 */
namespace service\resources\contractor\v1;

use common\components\ContractorSms;
use common\components\UserTools;
use common\models\LeContractor;
use common\models\VerifyCode;
use service\components\Tools;
use service\message\contractor\ContractorResponse;
use service\message\contractor\SmsLoginRequest;
use service\models\common\Contractor;
use service\models\common\ContractorException;

class smsLogin extends Contractor
{

    public function run($data)
    {
        /** @var SmsLoginRequest $request */
        $request = SmsLoginRequest::parseFromString($data);
        $contractor = LeContractor::findByPhone($request->getPhone());
        if(!$contractor){
            ContractorException::contractorNotExist();
        }else if($contractor->status == 0){
            ContractorException::contractorDisabled();
        }

        /** @var  VerifyCode $verify */
        $verify = VerifyCode::find()->where(['phone' => $request->getPhone(), 'verify_type' => ContractorSms::SMS_TYPE_LOGIN])->orderBy(['created_at' => SORT_DESC])->one();
        if ($verify) {
//            Tools::log('========','wangyang.log');
//            Tools::log($verify['created_at'],'wangyang.log');
//            Tools::log(strtotime($verify['created_at']),'wangyang.log');
//            Tools::log(time(),'wangyang.log');
//            Tools::log('========','wangyang.log');
            if(strtotime($verify['created_at']) + 60 < time()){
                ContractorException::verifyCodeAlreadyExpired();
            }else{
                if($request->getCode() == $verify['code']){
                    $contractor->auth_token = UserTools::getRandomString(16);
                    if($contractor->save()){
                        $this->initRole($contractor->entity_id,$contractor->auth_token);
                        $response = $this->getContractorInfo($contractor,$this->role_permission);
                        //Tools::log($response,'wangyang.log');
                        return $response;
                    }else{
                        ContractorException::contractorSystemError();
                    }
                }else{
                    ContractorException::verifyCodeError();
                }
            }
            
        }else{
            ContractorException::verifyCodeError();
        }
    }

    public static function request(){
        return new SmsLoginRequest();
    }

    public static function response(){
        return new ContractorResponse();
    }

}