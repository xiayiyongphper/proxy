<?php
namespace service\resources;

use common\models\extend\LeMerchantStoreExtend;
use common\models\Products;
use service\message\common\Store;
use service\message\merchant\getStoresByAreaIdsRequest;
use service\models\CoreConfigData;
use service\models\VarienObject;
use service\resources\merchant\v1\getStoresByAreaIds;
use yii\redis\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 15:10
 */
abstract class MerchantResourceAbstract extends ResourceAbstract
{

	protected $_wholesaler = [];

	/**
	 * 根据$storeModel返回商家详情数组
	 *
	 * @param \yii\base\Model $storeModel
	 */
	public static function getStoreDetail(\yii\base\Model $storeModel)
	{
		$merchantInfo = $storeModel->getAttributes();
		$data = [
			'wholesaler_id'        		=> $merchantInfo['entity_id'],
			'wholesaler_name'      		=> $merchantInfo['store_name'],
			'icon'                 		=> $merchantInfo['icon'],
			'logo'                 		=> $merchantInfo['logo'],
			'image'                		=> explode(';', $merchantInfo['shop_images']),
			'phone'                		=> [$merchantInfo['customer_service_phone']],
			'address'              		=> $merchantInfo['store_address'],
			//'description'				=>	json_encode(explode(';', $merchantInfo['shop_images'])),
			'area'                 		=> $merchantInfo['area_id'],
			'delivery_time'        		=> '3小时内接单,'.$merchantInfo['promised_delivery_time']?$merchantInfo['promised_delivery_time'].'小时送达':'',
			'min_trade_amount'     		=> $merchantInfo['min_trade_amount'],
			'business_license_img' 		=> $merchantInfo['business_license_img'],
			'business_license_code' 	=> $merchantInfo['business_license_code'],
			'tax_registration_certificate_img'  => $merchantInfo['tax_registration_certificate_img'],
			'organization_code_certificate_img' => $merchantInfo['organization_code_certificate_img'],
			'operate_time'         		=> $merchantInfo['operate_time'],
			'customer_service_phone'    => $merchantInfo['customer_service_phone'],
			'business_category'         => $merchantInfo['business_category'],
			'rebates'					=> $merchantInfo['rebates'],
			'rebates_text'				=> $merchantInfo['rebates'] ? '全场返现'.$merchantInfo['rebates'].'%' : '',
		];
		
		return array_filter($data);
	}

	/**
	 * 根据productModel返回商品简要信息数组
	 *
	 * @param \yii\base\Model $productModel
	 */
	public static function getProductBriefArray(Products $productModel)
	{
		$productInfo = $productModel->getAttributes();
		$gallery = explode(';', $productInfo['gallery']);
		$image = isset($gallery[0]) ? $gallery[0] : '';
		// 拼名字
		$name = Products::getProductNameText($productInfo);
		$data = [
			'product_id'    => $productInfo['entity_id'],
			'name'          => $name,
			'price'         => $productInfo['price'],
			'special_price' => $productInfo['special_price'],
			'image'         => $image,
			'qty'           => $productInfo['qty'],
			'sold_qty'      => $productInfo['sold_qty'],
			'gallery'       => $gallery,
            'promotion_text_from'   => $productInfo['promotion_text_from'],
            'promotion_text_to'     => $productInfo['promotion_text_to'],
            'promotion_text'        => $productInfo['promotion_text'],
            'product_description'   => $productInfo['description'],
		];

		return array_filter($data);
	}

	/**
	 * 查询给定商品的相关商品
	 *
	 * @param \yii\base\Model $productModel
	 */
	public function getRelatedProducts(\yii\base\Model $productModel, $recommendNum=3)
	{
		$recommendNum = ($recommendNum>20) ? 20:$recommendNum;// 最多给20个

		$productInfo = $productModel->getAttributes();

		// 目前相关商品的逻辑为,查找同供应商的同分类其他商品
		$wholesaler = $this->getWholesaler($productInfo['wholesaler_id']);

		$condition = [];
		$condition['wholesaler_id'] = $productInfo['wholesaler_id'];
		$condition = ['and',$condition,['third_category_id' => $productInfo['third_category_id']]];
		$condition = ['and', $condition,
			['not', ['entity_id' => $productInfo['entity_id']]]// 除去当前商品
		];

		// 商品的必要条件  2通过审核  1上架
		$condition = ['and',$condition,['state' => 2,'status' => 1]];

		// 查找
		$rProductModel = new Products($wholesaler->getAttribute('city'));
		$rProductList = $rProductModel->find()
			->where($condition)
			->limit($recommendNum)
			->all();

		return $rProductList;
	}

	/**
	 * 查找商家model
	 *
	 * @param $wholesaler_id
	 *
	 * @return ActiveRecord
	 * @throws \Exception
	 */
	protected function getWholesaler($wholesaler_id)
	{
		// 查新商家
		if (!isset($this->_wholesaler[$wholesaler_id])) {
			/** @var ActiveRecord $merchantModel */
			$merchantModel = LeMerchantStoreExtend::findMerchantByID($wholesaler_id);
			if (!$merchantModel) {
				$this->_wholesaler[$wholesaler_id] = -1;
			} else {
				$this->_wholesaler[$wholesaler_id] = $merchantModel;
			}
		}
		// 没有查到商家报错
		if (is_numeric($this->_wholesaler[$wholesaler_id]) && $this->_wholesaler[$wholesaler_id] == -1) {
			Exception::storeNotExisted();
		}

		// 返回商家model
		return $this->_wholesaler[$wholesaler_id];
	}

	/**
	 * Function: getProductDetailArray
	 * 根据productModel返回商品详情数组
	 * @param Products $productModel
	 * @return array
	 */
	public static function getProductDetailArray(Products $productModel)
	{
		$productInfo = $productModel->getAttributes();
		// 获取商家信息
		$wholesaler_id = $productInfo['wholesaler_id'];
		$wholesalerInfo = self::getStoreDetail(LeMerchantStoreExtend::findMerchantByID($wholesaler_id));
		// 拼商品名
		$name = Products::getProductNameText($productInfo);
		// 返点
		$rebates = $productInfo['rebates'];
		$rebates_lelai = CoreConfigData::getLeLaiRebates();
		$rebates_wholesaler = isset($wholesalerInfo['rebates']) ? $wholesalerInfo['rebates'] : 0;
		if($rebates>0){
			// 设置了商品单独的返点,则忽略商家全局的,但还是要加上乐来的全局
			$rebates_all = $rebates + $rebates_lelai;
		}else{
			$rebates_all = $rebates_lelai + $rebates_wholesaler;
		}
		// tag
		$tags = array(
			array(
				'text'	=> '返点'.$rebates_all.'%',
			),
		);

		// 商品信息更新
		$gallery = explode(';', $productInfo['gallery']);
		$image = isset($gallery[0]) ? $gallery[0] : '';
		$data = [
			'product_id'         => $productInfo['entity_id'],
			'name'               => $name,
			'image'              => $image,
			'price'              => $productInfo['price'],// TODO:此字段有待商榷
			'original_price'     => $productInfo['price'],
			'qty'                => $productInfo['qty'],
			'specification'      => $productInfo['specification'],
			'wholesaler_id'      => $productInfo['wholesaler_id'],
			'wholesaler_name'    => $wholesalerInfo['wholesaler_name'],
			'wholesaler_url'	   => 'wholesaler/index/index?sid='.$productInfo['wholesaler_id'],
			'barcode'            => $productInfo['barcode'],
			'first_category_id'  => $productInfo['first_category_id'],
			'second_category_id' => $productInfo['second_category_id'],
			'third_category_id'  => $productInfo['third_category_id'],
			'special_price'      => $productInfo['special_price'],
			'special_from_date'  => $productInfo['special_from_date'],
			'special_to_date'    => $productInfo['special_to_date'],
			'sold_qty'           => $productInfo['sold_qty'],
			'real_sold_qty'      => $productInfo['real_sold_qty'],
			'gallery'            => $gallery,
			'brand'              => $productInfo['brand'],
			'export'             => $productInfo['export'],
			'origin'             => $productInfo['origin'],
			'package_num'        => $productInfo['package_num'],
			'package_spe'        => $productInfo['package_spe'],
			'package'            => $productInfo['package'],
			'shelf_life'         => $productInfo['shelf_life'],
			'desc'               => $productInfo['description'],
			'status'             => $productInfo['status'],
			'state'              => $productInfo['state'],
            'promotion_text_from'   => $productInfo['promotion_text_from'],
            'promotion_text_to'     => $productInfo['promotion_text_to'],
            'promotion_text'        => $productInfo['promotion_text'],
            'product_description'   => $productInfo['description'],
            'minimum_order'   		=> $productInfo['minimum_order'],
			'rebates'				=> $productInfo['rebates'],
			'rebates_lelai'			=> $rebates_lelai,
			'rebates_wholesaler'	=> $rebates_wholesaler,
			'tags'					=> $tags,
		];

		// 商品参数
		$data['parameters'] = array();

		if ($productInfo['barcode']) {
			$data['parameters'][] = array(
				'key'   => '条形码',
				'value' => $productInfo['barcode'],
			);
		}
		$specificationText = self::getProductSpecificationText($productModel);
		if ($specificationText) {
			$data['parameters'][] = array(
				'key'   => '规格',
				'value' => $specificationText,
			);
		}
		if ($productInfo['brand']) {
			$data['parameters'][] = array(
				'key'   => '品牌',
				'value' => $productInfo['brand'],
			);
		}

		//print_r($data);echo PHP_EOL;
		return array_filter($data);
	}

	/**
	 * 根据$productModel拼接产品规格信息
	 *
	 * @param \yii\base\Model $productObj
	 *
	 * @return string
	 */
	public static function getProductSpecificationText(\yii\base\Model $productModel)
	{
		$productArray = $productModel->getAttributes();
		return Products::getProductSpecificationText($productArray);
	}

	/**
	 * 给出areaId,返回该区域的所有商家
	 *
	 * @param $areaId
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public static function getAreaWholesalers($areaId, $columns = '*')
	{
		// 否则就查该区域的商家id
		$rq = new getStoresByAreaIdsRequest();
		$rq->appendAreaIds($areaId);
		$handler = new getStoresByAreaIds();
		$rp = $handler->run($rq->serializeToString());;
		$wholesalerList = $rp->get('wholesaler_list');

		if ($columns != '*' && is_string($columns)) {
			$columns = [$columns];
		}

		$wholesalerInfo = [];
		/** @var Store $item */
		foreach ($wholesalerList as $item) {
			if ($columns == '*') {
				$row = $item->toArray();
			} else {
				$row = [];
				$row['wholesaler_id'] = $item->get('wholesaler_id');
				foreach ($columns as $column) {
					$row[$column] = $item->get($column);
				}
			}
			//array_push($wholesalerInfo, $row);
			$wholesalerInfo[$row['wholesaler_id']] = $row;

		}

		return $wholesalerInfo;
	}
}