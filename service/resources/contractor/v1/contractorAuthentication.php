<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/1/22
 * Time: 16:51
 */

namespace service\resources\contractor\v1;


use common\models\LeContractor;
use service\components\Tools;
use service\message\contractor\ContractorAuthenticationRequest;
use service\message\contractor\ContractorResponse;
use service\message\customer\CustomerAuthenticationRequest;
use service\models\common\Contractor;

class contractorAuthentication extends Contractor
{

    /**
     * @param string $data
     * Author Jason Y. wang
     *
     * @return bool|\service\message\contractor\ContractorResponse
     */
    public function run($data)
    {
        /** @var ContractorAuthenticationRequest $request */
        $request = ContractorAuthenticationRequest::parseFromString($data);
        Tools::log($request, 'wangyang.log');
        /** @var LeContractor $contractor */
        $contractor = $this->initContractor($request);
        $response = $this->getContractorInfo($contractor,$this->role_permission);
        return $response;
    }

    public static function request()
    {
        return new CustomerAuthenticationRequest();
    }

    public static function response()
    {
        return new ContractorResponse();
    }

}