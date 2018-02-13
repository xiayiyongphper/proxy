<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 18:31
 */
namespace service\resources\sales\v1;

use service\components\Tools;
use service\message\customer\TestReportRequest;
use service\resources\ResourceAbstract;

class test extends ResourceAbstract
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
        Tools::log('============test=============','sales_report_for_audit.log');
        Tools::log('IP:'.$this->getRemoteIp(),'sales_report_for_audit.log');
        Tools::log($request,'sales_report_for_audit.log');
    }

    public static function request(){
        return new TestReportRequest();
    }

    public static function response(){
        return true;
    }

}