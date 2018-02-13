<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 18:31
 */
namespace service\resources\customers\v1;

use service\components\Tools;
use service\message\customer\TestReportRequest;
use service\models\common\Customer;

class test extends Customer
{
    /**
     * Function: run
     * Author: Jason Y. Wang
     *
     * @param $data
     * @return mixed|void
     */
    public function run($data)
    {
        /** @var TestReportRequest $request */
        $request = TestReportRequest::parseFromString($data);
        Tools::log('============test=============','customers_report_for_audit.log');
        Tools::log('IP:'.$this->getRemoteIp(),'customers_report_for_audit.log');
        Tools::log($request,'customers_report_for_audit.log');
    }

    public static function request(){
        return new TestReportRequest();
    }

    public static function response(){
        return true;
    }

}