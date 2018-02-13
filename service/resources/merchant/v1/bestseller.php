<?php
/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 17-1-10
 * Time: 上午10:25
 */
namespace service\resources\merchant\v1;

use common\models\LeMerchantStore;
use common\models\Products;
use framework\components\ToolsAbstract;
use service\components\Redis;
use service\components\Tools;
use service\message\customer\CustomerResponse;
use service\message\merchant\bestsellerRequest;
use service\message\merchant\bestsellerResponse;
use service\models\ProductHelper;
use service\resources\MerchantException;
use service\resources\MerchantResourceAbstract;
use yii\db\Expression;
use yii\db\Query;

class bestseller extends MerchantResourceAbstract
{
    public function run($data)
    {
        /** @var bestsellerRequest $request */
        $request = bestsellerRequest::parseFromString($data);
        /** @var CustomerResponse $customer */
        $customer = $this->_initCustomer($request);
        $redis = Tools::getRedis();
        $key = $this->getCacheKey($request->getWholesalerId());
        $response = self::response();
        if (true||!$redis->exists($key)) {
            $responseData = $this->_run($request, $customer);
            $redis->set($key, serialize($responseData), 86400);
        } else {
            $data = unserialize($redis->get($key));
            if ($data === false) {
                $responseData = $this->_run($request, $customer);
                $redis->set($key, serialize($responseData), 86400);
            } else {
                $responseData = $data;
            }
        }
//        ToolsAbstract::log(ToolsAbstract::pb_array_filter($responseData));
        $response->setFrom(ToolsAbstract::pb_array_filter($responseData));
        return $response;
    }

    public static function request()
    {
        return new bestsellerRequest();
    }

    public static function response()
    {
        return new bestsellerResponse();
    }

    public function getCacheKey($wholesaler_id)
    {
        return sprintf('bestseller_%s', $wholesaler_id);
    }

    /**
     * @param bestsellerRequest $request
     * @param customerResponse $customer
     * @return array
     */
    private function _run($request, $customer)
    {
        $wholesaler = LeMerchantStore::findOne(['entity_id' => $request->getWholesalerId()]);
        //用户城市与供货商城市不匹配，
        if ($customer->getCity() != $wholesaler->city) {
            MerchantException::customerWholesalerCityNotMatch();
        }
        $productModel = new Products($customer->getCity());
        //返回有商品的一级分类
        $ids = $productModel::find()->select('first_category_id')->where(['wholesaler_id' => $wholesaler->entity_id])
            ->andWhere(['status' => Products::STATUS_ENABLED, 'state' => Products::STATE_APPROVED])
            ->groupBy('first_category_id')->column();
        //分类展示顺序
        $categories = Redis::getCategories($ids);
        $columns = $productModel::getTableSchema()->getColumnNames();
        $dummyQuery = new Query();
        $dummyQuery->from('products_city_structure')->addSelect($columns)->andWhere('1 = 0');
        foreach ($categories as $id => $category) {
            $sql = $productModel::find()
                ->addSelect($columns)
                ->andWhere(['>', 'price', 0])
                ->andWhere(['status' => Products::STATUS_ENABLED, 'state' => Products::STATE_APPROVED])
                ->andWhere(['first_category_id' => $id])
                ->orderBy(new Expression('real_sold_qty desc,sort_weights desc'))
                ->limit(9)
                ->createCommand()
                ->getRawSql();
            $dummyQuery->union($sql);
        }
        $unionQuery = new Query();
        $unionQuery->from(['dummy_name' => $dummyQuery]);
        //Tools::log($unionQuery->createCommand(Products::getDb())->getRawSql());
        $items = $unionQuery->all(Products::getDb());
        $helper = new ProductHelper();
        $products = $helper->initWithProductArray($items, $customer->getCity())->getTags()->getData();
        $blocks = [];
        foreach ($categories as $category) {
            $product_list = [];
            foreach ($products as $product) {
                if ($product['first_category_id'] == $category['id']) {
                    $product_list[] = $product;
                }
            }
            if (count($product_list) > 0) {
                $blocks[] = [
                    'category' => $category,
                    'product_list' => $product_list
                ];
            }
        }
        $responseData['blocks'] = $blocks;
        $responseData['top_banner'] = [
            'src' => 'http://assets.lelai.com/images/catalog/product/600x600/20161220/69530297101670_1.jpg'
        ];
        return $responseData;
    }
}