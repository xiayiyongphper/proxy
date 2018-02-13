<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 21/1/2016
 * Time: 5:58 PM
 */
namespace service\resources\merchant\v1;

use common\models\LeStoreHomepageConf;
use common\models\Products;
use framework\components\Date;
use service\components\Proxy;
use service\components\Redis;
use service\components\Tools;
use service\message\common\Store;
use service\message\merchant\getStoreDetailRequest;
use service\models\ProductHelper;
use service\resources\Exception;
use service\resources\MerchantResourceAbstract;
use yii\db\Expression;


class getStoreDetail1 extends MerchantResourceAbstract
{
	public function run($data)
	{
		/** @var getStoreDetailRequest $request */
		$request = $this->request()->parseFromString($data);

		$wholesaler_id = $request->getWholesalerId();
		$customer = null;
		if($request->getCustomerId() && $request->getAuthToken()){
			$customer = $this->_initCustomer($request);
		}

		if(!$wholesaler_id){
			Exception::storeNotExisted();
		}

        if($customer){
            if($this->isRemote()){
                $wholesaler_ids = self::getWholesalerIdsByAreaId($customer->getAreaId());
                if(!in_array($wholesaler_id,$wholesaler_ids)){
                    Exception::invalidRequestRoute();
                }
            }
        }

		// redis读
		$wholesalers_info = Redis::getWholesalers([$wholesaler_id]);
		$wholesaler_info = unserialize($wholesalers_info[$wholesaler_id]);
		if(!$wholesaler_info){
			Exception::storeNotExisted();
		}


		$response = $this->response();
		if($customer){
			$data = MerchantResourceAbstract::getStoreDetail($wholesaler_info,$customer->getAreaId());
		}else{
			$data = MerchantResourceAbstract::getStoreDetail($wholesaler_info);
		}
		//去掉默认banner
		foreach ($data['banner'] as $key => $banner){
			if($banner['src'] == self::$bannerUrl){
				unset($data['banner'][$key]);
			}
		}

		//是否展示领取优惠券按钮
		$coupons = Proxy::getCouponReceiveList(2,0,$wholesaler_id);
		//Tools::wLog($coupons);
		if($coupons){
			$data['coupon_receive_layout'] = [
				'banner_image' => 'http://assets.lelai.com/assets/coupon/group.png',
			];
		}

		// 供应商首页单独的配置
		$model = LeStoreHomepageConf::find()
			->where(['store_id'=>$wholesaler_id])
			->andWhere(['status'=>2])
			->one();
		if($model){
			$model = $model->toArray();
		}
		if(isset($model["json"])){
			$homepage_config = json_decode($model["json"], true);

			if($homepage_config!==NULL){
				// 到这里才是真正有配置
				// 处理需要自动选品的product块
				// 1.特价商品
				if(isset($homepage_config['product_blocks'])){
					// 每日特价最多显示多少个
					$display_num = 15;
					// 找到"每日特价"的块index
					$product_blocks = $homepage_config['product_blocks'];
					$index_flag = false;
					foreach ($product_blocks as $index => $product_block) {
						if($product_block['title']=='每日特价'){
							$index_flag = $index;
							break;
						}
					}
					// 若有"每日特价"则填充
					if($index_flag!==false && is_array($homepage_config['product_blocks'][$index_flag]['products']) ){
						$fill_count = $display_num - count($homepage_config['product_blocks'][$index_flag]['products']);
						$selected_product_ids = $homepage_config['product_blocks'][$index_flag]['products'];
						$fill_products = $this->getWholesalerAllSpecialPriceProduct($wholesaler_info, $fill_count, $selected_product_ids);
						if(count($fill_products)>$display_num){
							array_slice($fill_products, 0, $display_num);
						}
						$homepage_config['product_blocks'][$index_flag]['products'] = $fill_products;
					}
				}

				$data['homepage_config'] = $homepage_config;
			}
		}
		//Tools::log(Tools::pb_array_filter($data));
		$response->setFrom(Tools::pb_array_filter($data));
		return $response;
	}

	public function getWholesalerAllSpecialPriceProduct($wholesaler_info, $fill_count, $selected_product_ids){

		//Tools::log($wholesaler_info);
		//Tools::log($fill_count);
		//Tools::log($selected_product_ids);

		$wholesaler_id = $wholesaler_info['entity_id'];
		$city = $wholesaler_info['city'];

		$date = new Date();
		$now = $date->gmtDate();

		$model = new Products($city);
		// 先查选中的
		$dbProducts = $model->find()->where(['wholesaler_id'=>$wholesaler_id])
			->andWhere(['IN', 'entity_id', $selected_product_ids])
			->andWhere(new Expression('special_price<price'))
			->andWhere(['<', 'special_from_date', $now])
			->andWhere(['>', 'special_to_date', $now])
			->all();

		// 再查补充的
		if($fill_count>0){
			$dbFillProducts = $model->find()->where(['wholesaler_id'=>$wholesaler_id])
				->andWhere(['NOT IN', 'entity_id', $selected_product_ids])
				->andWhere(new Expression('special_price<price'))
				->andWhere(['<', 'special_from_date', $now])
				->andWhere(['>', 'special_to_date', $now])
				->limit($fill_count)
				->all();
			foreach ($dbFillProducts as $dbFillProduct) {
				array_push($dbProducts, $dbFillProduct);
			}
		}

		$productArray = Redis::processDbProducts($city, $dbProducts);
		//Tools::log($productArray);


		$products = (new ProductHelper())->initWithProductArray($productArray, $city)
			->getTags()
			->getData();

		return $products;
	}

	public static function request()
	{
		return new getStoreDetailRequest();
	}

	public static function response()
	{
		return new Store();
	}
}