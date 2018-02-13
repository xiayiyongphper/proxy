<?php
namespace service\resources\sales\v1;

use common\models\salesrule\Rule;
use common\models\salesrule\Usage;
use common\models\salesrule\UserCoupon;
use framework\components\Date;
use service\components\Tools;
use service\message\core\CouponReceiveListRequest;
use service\message\core\CouponReceiveListResponse;
use service\message\core\ReceiveCouponRequest;
use service\resources\Exception;
use service\resources\ResourceAbstract;

/**
 * Class receiveCoupon
 * @package service\resources\sales\v1
 */
class receiveCoupon extends ResourceAbstract
{

    public function run($data)
    {

        // 考虑一个券可以领取多次的情况,要先获取这个优惠券的信息
        // 考虑所有用户领取总数达到上线的情况
        // 考虑单个用户领取总数达到上线的情况

        // 一个规则可以领取多次，用过后才可以领
        // 领过后不能在领
        // 还没到期的规则，领了不能用，过几天在用   有效期还用原来的

        // 截止时间-有效期 > 0

        //领取后加入缓存


        /** @var ReceiveCouponRequest $request */
        $request = ReceiveCouponRequest::parseFromString($data);
        //Tools::log($request, 'wangyang.log');
        //数据
        $date = new Date();
        $date = $date->date();
        $rule_id = $request->getRuleId();
        $coupon_code = $request->getCoupon();

        $rule = '';
        if($rule_id > 0){
            //要领取的优惠券ID，手动领取
            /** @var Rule $rule */
            $rule = Rule::getCouponRuleByRuleId($rule_id,Rule::RULE_COUPON_SHOW);

        }else if(!empty($coupon_code)){
            //Tools::log($coupon_code,'wangyang.log');
            //要领取的优惠券码，优惠码兑换
            /** @var Rule $rule */
            $rule = Rule::getCouponRuleByCouponCode($coupon_code);
            //Tools::log($rule,'wangyang.log');
            if(!$rule){
                Exception::couponNumberError();
            }
            $rule_id = $rule->rule_id;
        }else{
            Exception::invalidRequestRoute();
        }

        if(!$rule || $rule->to_date < $date){
            //可能是优惠券配置错误导致，提示优惠券活动已结束
            Exception::couponExpire();
        }

        //用户信息
        $customerResponse = $this->_initCustomer($request, true);
        $customerId = $customerResponse->getCustomerId();
        //领取缓存
        $couponKey = UserCoupon::COUPON_KEY_PREFIX.$rule_id;

        $redis = Tools::getRedis();
        $totalCount = $redis->hLen($couponKey);
//        Tools::log($couponKey,'wangyang.log');
//        Tools::log($redis,'wangyang.log');
//        Tools::log($totalCount,'wangyang.log');

        //先判断所有用户领取是否达到上线
        if ($totalCount >= $rule->uses_per_coupon) {
            Exception::couponReceiveOut();
        }
        //判断单个用户领取是否达到上线
        $userTotalCount = $redis->hGet($couponKey,$customerId);
        if($userTotalCount > $rule->uses_per_coupon){
            Exception::couponUserReceiveOut();
        }

        //领取优惠券
        $result = Rule::getCoupon($rule,$customerId,UserCoupon::COUPON_SOURCE_RECEIVE);
        if(!$result){
            Exception::couponReceivedError();
        }
        //领取成功记录到redis
        $redis->hIncrBy($couponKey,$customerId,1);
        return true;
    }

    public static function request()
    {
        return new CouponReceiveListRequest();
    }

    public static function response()
    {
        return true;
    }
}