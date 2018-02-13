<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 8/12/2016
 * Time: 5:48 PM
 */

namespace service\resources\sales\v1;

use common\models\salesrule\UserCoupon;
use framework\components\Date;
use service\message\sales\getCustomerCouponAvailableCountRequest;
use service\message\sales\getCustomerCouponAvailableCountResponse;
use service\resources\ResourceAbstract;

class getCustomerCouponAvailableCount extends ResourceAbstract
{
	public function run($data){

		/** @var getCustomerCouponAvailableCountRequest $request */
		$request = self::request()->parseFromString($data);
		$this->_initCustomer($request);

		// 未过期优惠券数量
		$date = new Date();
		$coupon_available_count = UserCoupon::find()
			->where(['customer_id'=>$request->getCustomerId()])
			->andWhere(['state'=>UserCoupon::USER_COUPON_UNUSED])
			->andWhere(['>', 'expiration_date', $date->date('Y-m-d H:i:s')])
			->count();

		$response = self::response();
		$response->setFrom([
			'coupon_available_count' => $coupon_available_count,
		]);
		return $response;
	}

//    private function getOrders($condition){
//        $orders = new SalesFlatOrder();
//        $orders->find()->where($condition);
//    }

	public static function request()
	{
		return new getCustomerCouponAvailableCountRequest();
	}

	public static function response()
	{
		return new getCustomerCouponAvailableCountResponse();
	}

}