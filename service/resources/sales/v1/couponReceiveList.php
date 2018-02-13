<?php
namespace service\resources\sales\v1;

use common\models\salesrule\Rule;
use service\components\Tools;
use service\message\core\CouponReceiveListRequest;
use service\message\core\CouponReceiveListResponse;
use service\resources\ResourceAbstract;

class couponReceiveList extends ResourceAbstract
{
    public function run($data)
    {
        /** @var CouponReceiveListRequest $request */
        $request = CouponReceiveListRequest::parseFromString($data);
        $response = new CouponReceiveListResponse();
        //1、商品详情  2、 供应商首页  3、专题页面 4、购物车页面
        $location = $request->getLocation();
        $wholesaler_id = $request->getWholesalerId();
        $rule_id = $request->getRuleId();
        $coupons = [];

//        Tools::log($wholesaler_id,'wangyang.log');
//        Tools::log($rule_id,'wangyang.log');
//        Tools::log($location,'wangyang.log');

        //1、商品详情  2、 供应商首页  3、专题页面 4、购物车页面
        switch ($location){
            case 1:
                $coupons = Rule::generateCoupons($rule_id,$wholesaler_id);
                break;
            case 2:
                $coupons = Rule::generateCoupons(null,$wholesaler_id);
                break;
            case 3:
                $coupons = Rule::generateCoupons($rule_id,null);
                break;
            case 4:
                $coupons = Rule::generateCoupons(null,$wholesaler_id);
                break;
            default:
                break;
        }

        $response->setFrom(Tools::pb_array_filter(['coupon_receive' => $coupons]));
        return $response;
    }

    protected function getCouponByWholesalerId($productId)
    {

    }

    public static function request()
    {
        return new CouponReceiveListRequest();
    }

    public static function response()
    {
        return new CouponReceiveListResponse();
    }
}