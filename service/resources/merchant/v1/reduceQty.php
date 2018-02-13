<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 1/2/2016
 * Time: 2:17 PM
 */

namespace service\resources\merchant\v1;

use common\models\extend\LeMerchantStoreExtend;
use common\models\Products;
use service\components\Tools;
use service\components\Transaction;
use service\message\common\UpdateCartItems;
use service\message\merchant\reduceQtyRequest;
use service\message\merchant\reduceQtyResponse;
use service\resources\Exception;
use service\resources\MerchantResourceAbstract;
use yii\db\ActiveRecord;

class reduceQty extends MerchantResourceAbstract
{

	public $checkCustomer = null;

	public function run($data)
	{

		/** @var reduceQtyRequest $request */
		$request = $this->request()->parseFromString($data);

		// 检查登录态
		if ($this->checkCustomer===false){
			// 主动设置false，肯定不检测
		}elseif(!$this->isRemote()){
			// 主动设置local，则不检测
		}else{
			$customer = $this->_initCustomer($request);
		}

		// 商品列表
		$products = $request->getProducts();

		return $this->reduce($products);

	}


	/**
	 * @param $products array 商品列表
	 *
	 * @return reduceQtyResponse
	 * @throws \Exception
	 */
	public function reduce($products)
	{

		// 商品列表
		// $products = $request->getProducts();

		// 减库存的transaction
		$transaction = new Transaction();

		// 按商家id分组商品列表
		$productsByWholesaler = [];
		/** @var UpdateCartItems $product */
		foreach ($products as $product) {
			$wholesaler_id = $product->getWholesalerId();
			if (!isset($productsByWholesaler[$wholesaler_id])) {
				$productsByWholesaler[$wholesaler_id] = [];
			}
			array_push($productsByWholesaler[$wholesaler_id], $product->toArray());
		}


		/*
		 * 检查上下架和审核状态
		 */
		foreach ($productsByWholesaler as $wholesaler_id => $items) {
			// 查商家所在城市
			$merchantModel = $this->getWholesaler($wholesaler_id);
			$city = $merchantModel->getAttribute('city');

			// 检查这个商家的商品是否下架或者未审核通过
			$this->checkItemsState($wholesaler_id, $city, $items);
		}

		/*
		 * 检查库存
		 */
		/** @var \yii\db\Connection $db */
		$db = \Yii::$app->get('productDb');
		$hasBeginTransaction = false;
        $clear_redis = [];
		foreach ($productsByWholesaler as $wholesaler_id => $items) {
			// 查商家所在城市
			$merchantModel = $this->getWholesaler($wholesaler_id);
			$city = $merchantModel->getAttribute('city');

			// 检查这个商家的库存
			$this->checkItemsQty($wholesaler_id, $city, $items);

			// 可以减库存
			if (!$hasBeginTransaction) {
				$transaction = $db->beginTransaction();
				$hasBeginTransaction = true;
			}
			$table = 'products_city_' . $city;
			foreach ($items as $item) {
				$pid = $item['product_id'];
                $clear_redis['product_'.$city][] = $pid;
                $num = $item['num'];
                $sql = "UPDATE {$table} SET `qty` = `qty`-{$num}, `sold_qty` = `sold_qty` + {$num}, `real_sold_qty` = `real_sold_qty` + {$num} WHERE `wholesaler_id` = '{$wholesaler_id}' AND `entity_id`='{$pid}';";
				$db->createCommand($sql)->execute();
			}

		}

		/*
		 * 库存检查成功,开始减库存
		 */
		// 能运行到这里说明之前都没抛异常,可以开始减库存
		try {
			$transaction->commit();

            //删除redis 重新拉库存
            $redis = Tools::getRedis();
            foreach ($clear_redis as $city => $product_ids){
                foreach ($product_ids as $product_id){
                    $redis->hDel($city,$product_id);
                }
            }
			$success = true;
		} catch (\Exception $e) {
			Tools::logException($e);
			$transaction->rollBack();
			$success = false;
			throw $e;
		}

		/** @var reduceQtyResponse $response */
		$response = $this->response();
		if ($success) {
			$response->setCode(0);
			$response->setMessage('ok');
		} else {
			$response->setCode(0);
			$response->setMessage('unknow error');
		}

		return $response;

	}

	public static function request()
	{
		return new reduceQtyRequest();
	}

	/**
	 * 检查所给商品数组里是否存在未审核通过或者下架商品
	 *
	 * @param $wholesaler_id
	 * @param $city
	 * @param $items
	 *
	 * @throws \Exception
	 */
	private function checkItemsState($wholesaler_id, $city, $items)
	{
		// 检查这个商家的商品是否下架或者未审核通过
		$productModel = new Products($city);
		$pCondition = [];
		foreach ($items as $item) {
			// $sCondition => state!=2 or status!=2
			$sCondition = ['!=', 'state', 2];
			$sCondition = ['or', $sCondition,
				['!=', 'status', 1]// 状态
			];
			// $sCondition => entity_id=xxx and (state!=2 or status!=2)
			$iCondition = ['and', $sCondition, ['entity_id' => $item['product_id']]];

			// $pCondition => (entity_id=xxx and (state!=2 or status!=2)) or (entity_id=xxx and (state!=2 or status!=2))
			if (count($pCondition) == 0) {
				$pCondition = $iCondition;
			} else {
				$pCondition = ['or', $pCondition, $iCondition];
			}
		}
		$condition = ['and', ['wholesaler_id' => $wholesaler_id], $pCondition];
		$productList = $productModel->find()
			->where($condition);
		if ($productList->count() > 0) {
			// 找到,则说明有商品状态不对
			Exception::catalogProductNotFound();
		}
	}

	private function checkItemsQty($wholesaler_id, $city, $items)
	{
		// 检查这个商家的库存
		$productModel = new Products($city);
		$pCondition = [];
		foreach ($items as $item) {
			$iCondition = ['entity_id' => $item['product_id']];
			$iCondition = ['and', $iCondition,
				['<', 'qty', $item['num']]// 库存小于购买数
			];
			if (count($pCondition) == 0) {
				$pCondition = $iCondition;
			} else {
				$pCondition = ['or', $pCondition, $iCondition];
			}
		}
		$condition = ['and', ['wholesaler_id' => $wholesaler_id], $pCondition];
		$productList = $productModel->find()
			->where($condition);
		if ($productList->count() > 0) {
			// 找到就是库存不足
			$names = [];
			foreach ($productList->all() as $product) {
				$name = $product->getAttribute('brand') . $product->getAttribute('name');
				array_push($names, $name);
			}
			Exception::catalogProductSoldOut2(implode('、', $names));
		}
	}

	public static function response()
	{
		return new reduceQtyResponse();
	}
}