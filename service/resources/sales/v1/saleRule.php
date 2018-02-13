<?php
namespace service\resources\sales\v1;

use common\models\salesrule\Rule;
use service\components\Tools;
use service\message\merchant\SaleRuleRequest;
use service\message\merchant\SaleRuleResponse;
use service\resources\ResourceAbstract;

class saleRule extends ResourceAbstract
{
    public function run($data)
    {
        /** @var SaleRuleRequest $request */
        $request = SaleRuleRequest::parseFromString($data);
        $response = new SaleRuleResponse();
        $rule_id = $request->getRuleId();
        $wholesaler_id = $request->getWholesalerId();
        $promotions = [];
        if(count($rule_id)){
            $promotions = Rule::getProductPromotions($rule_id);
        }else if ($wholesaler_id){
            $promotions = Rule::getWholesalerPromotions($wholesaler_id);
        }
//        Tools::log($promotions,'wangyang.log');
        $response->setFrom(Tools::pb_array_filter(['promotions' => $promotions]));
        //Tools::log('111111111','wangyang.log');
        //Tools::log($response,'wangyang.log');
        return $response;
    }

    public static function request()
    {
        return new SaleRuleRequest();
    }

    public static function response()
    {
        return new SaleRuleResponse();
    }
}