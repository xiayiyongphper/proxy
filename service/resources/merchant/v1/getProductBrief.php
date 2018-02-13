<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 21/1/2016
 * Time: 5:58 PM
 */
namespace service\resources\merchant\v1;

use common\models\Products;
use service\components\Redis;
use service\components\Tools;
use service\message\merchant\getProductBriefRequest;
use service\message\merchant\getProductBriefResponse;
use service\models\ProductHelper;
use service\resources\MerchantResourceAbstract;


class getProductBrief extends MerchantResourceAbstract
{
	public function run($data)
	{
        $timeStart = microtime(true);
		/** @var getProductBriefRequest $request */
		$request = $this->request()->parseFromString($data);

		$response = $this->response();
		$productIds = $request->getProductIds();

//		$products = MerchantResourceAbstract::getProductsArrayPro2($productIds,$request->getCity());

        $products = (new ProductHelper())->initWithProductIds($productIds,$request->getCity())
            ->getTags()
            ->getData();

		$result = [
			'product_list' => Tools::pb_array_filter($products)
		];
//        Tools::log($result,'wangyang.log');
		$response->setFrom(Tools::pb_array_filter($result));
        $timeEnd = microtime(true);
        //Tools::log($timeEnd-$timeStart,'wangyang.log');
        return $response;
	}

	public static function request()
	{
		return new getProductBriefRequest();
	}

	public static function response()
	{
		return new getProductBriefResponse();
	}
}