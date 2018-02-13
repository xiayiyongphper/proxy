<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 21/1/2016
 * Time: 5:58 PM
 */
namespace service\resources\merchant\v1;


use common\models\Products;
use service\components\Tools;
use service\message\merchant\getProductRequest;
use service\message\merchant\getProductResponse;
use service\models\ProductHelper;
use service\resources\Exception;
use service\resources\MerchantResourceAbstract;
use yii\db\ActiveRecord;


class getProduct extends MerchantResourceAbstract
{
    public function run($data)
    {
        /** @var getProductRequest $request */
        $request = $this->request()->parseFromString($data);
        $customer = null;
        $wholesaler_ids = [];
        if ($request->getCustomerId() && $request->getAuthToken()) {
            $customer = $this->_initCustomer($request);
            $wholesaler_ids = self::getWholesalerIdsByAreaId($customer->getAreaId());
        }

        if ($customer) {
            $merchantInfo = $this->getStoreDetailBrief([$request->getWholesalerId()], $customer->getAreaId());
            $merchantInfo = $merchantInfo[$request->getWholesalerId()];
        } else {
            // 查商家
            /** @var ActiveRecord $merchantModel */
            $merchantModel = $this->getWholesaler($request->getWholesalerId());
            $merchantInfo = $this->getStoreDetail($merchantModel);
        }

        // redis查询(数据库级的缓存)
        $city = $merchantInfo['city'];
        $product_ids = $request->getProductIds();
        // 组装返回
        $response = $this->response();
        if (count($product_ids) > 0) {
            $result = [];
            /** @var Products $item */
            foreach ($product_ids as $key => $product_id) {

                // 格式化详情数组
                $data = (new ProductHelper())->initWithProductIds($product_id, $city, [], '600x600')
                    ->getMoreProperty()
                    ->getTags()
                    ->getParameters()
                    ->getCouponReceive()
                    ->getData();

                $product_data = $data[$product_id];

                if ($customer) {
                    if (!in_array($product_data['wholesaler_id'], $wholesaler_ids)) {
                        Exception::invalidRequestRoute();
                    }
                }

                //Tools::wLog($product_data);

                if ($customer) {
                    $product_data['purchased_qty'] = Tools::getPurchasedQty($customer->getCustomerId(), $customer->getCity(), $product_id);
                }

                //查询相关商品
                $recommendNum = intval($request->getRecommendNum());
                if ($recommendNum) {
                    $rProductList = $this->getRelatedProducts($city, $product_data, $recommendNum);
                } else {
                    $rProductList = $this->getRelatedProducts($city, $product_data);
                }

                //$product_data['recommend_list'] = MerchantResourceAbstract::getProductsArrayPro($rProductList, $merchantInfo, $lelai_rebates);
                $product_data['recommend_list'] = (new ProductHelper())->initWithProductArray($rProductList, $city)->getData();;
                // 插入
                array_push($result, $product_data);
            }
            $result = [
                'product_list' => $result,
                'wholesaler_info' => $merchantInfo,
            ];
            //Tools::log($result,'wangyang.log');
            $response->setFrom(Tools::pb_array_filter($result));
        } else {
            throw new \Exception('无商品', 4501);
        }
        return $response;
    }

    public static function request()
    {
        return new getProductRequest();
    }

    public static function response()
    {
        return new getProductResponse();
    }
}