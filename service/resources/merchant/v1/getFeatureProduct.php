<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 21/1/2016
 * Time: 5:58 PM
 */
namespace service\resources\merchant\v1;

use common\models\LeMerchantProductList;
use common\models\LeMerchantStore;
use common\models\Products;
use service\components\Tools;
use service\message\merchant\getFeatureProductsRequest;
use service\message\merchant\getFeatureProductsResponse;
use service\message\merchant\getProductRequest;
use service\resources\MerchantResourceAbstract;



class getFeatureProduct extends MerchantResourceAbstract
{
	public function run($data)
	{
		$timeStart = microtime(true);
		/** @var getProductRequest $request */
		$request = $this->request()->parseFromString($data);

		$customer = $this->_initCustomer($request);
		/** @var LeMerchantStore $merchantModel */
		$merchantModel = $this->getWholesaler($request->getWholesalerId());
		$merchantModel = self::getStoreDetail($merchantModel);
		$identifier = 'featured_product_list';
		$list = LeMerchantProductList::find()
			->where(['identifier' => $identifier,])
			->andWhere(['wholesaler_id' => $request->getWholesalerId()])->asArray()->all();
		$barcodeArray = [];
		foreach ($list as $item) {
			$barcode = $item['barcode'];
			$barcode = explode(';', $barcode);
			$barcode = array_filter($barcode);
			$barcodeArray = array_merge($barcodeArray, $barcode);
		}

		$productModel = new Products($customer->getCity());
		$_products = $productModel::find()
			->where(['in', 'barcode', $barcodeArray])
			->andWhere(['wholesaler_id' => $request->getWholesalerId()])
			->andWhere(['status' => Products::STATUS_ENABLED, 'state' => Products::STATE_APPROVED])
			->andWhere(['>', 'price', 0])
			->orderBy('sort_weights desc')
			->limit(30)->asArray()->all();
		$block = [];
		$block['product_list'] = self::getProductsArrayPro($_products,$merchantModel);
//		/** @var array $_product */
//		foreach ($_products as $_product) {
//			$_mrgProduct = self::getProductBriefArray($_product);
//			$_mrgProduct['wholesaler_name'] = $merchantModel['wholesaler_name'];
//			$block['product_list'][] = $_mrgProduct;
//		}
		//Tools::log($block,'wangyang.log');
		$response = $this->response();

		$response->setFrom(Tools::pb_array_filter($block));
		$timeEnd = microtime(true);
		//Tools::log($timeEnd-$timeStart,'wangyang.log');
		return $response;
	}

	public static function request()
	{
		return new getFeatureProductsRequest();
	}

	public static function response()
	{
		return new getFeatureProductsResponse();
	}
}