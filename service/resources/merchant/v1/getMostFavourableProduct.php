<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 21/1/2016
 * Time: 5:58 PM
 */
namespace service\resources\merchant\v1;

use common\models\Products;
use framework\data\Pagination;
use service\components\Tools;
use service\message\merchant\searchProductRequest;
use service\message\merchant\searchProductResponse;
use service\models\ProductHelper;
use service\resources\MerchantResourceAbstract;
use yii\db\Expression;


class getMostFavourableProduct extends MerchantResourceAbstract
{
    public function run($data)
    {
        /** @var searchProductRequest $request */
        $request = $this->request()->parseFromString($data);

        $customer = $this->_initCustomer($request);
        $wholesaler_id = $request->getWholesalerId();

        //分页设置
        $page = $request->getPage() ?: 1;
        $pageSize = $request->getPageSize() ?: 20;

        $productModel_one = new Products($customer->getCity());
        $productModel_one = $productModel_one->find()->where(['>','label1',0])
            ->andWhere(['status' => Products::STATUS_ENABLED, 'state' => Products::STATE_APPROVED]);
        if($wholesaler_id > 0){
            $productModel_one = $productModel_one->andWhere(['wholesaler_id' => $wholesaler_id]);
        }

        $productModel_two = new Products($customer->getCity());
        $where = 'label1&'.self::PRODUCT_FAVOURABLE_TAG.'=1';
        $condition = new Expression($where);
        $productModel_two = $productModel_two->find()->from(['one' => $productModel_one])->where($condition)->orderBy('price asc');

        $productModel_three = new Products($customer->getCity());
        $productModel_three = $productModel_three->find()->from(['two' => $productModel_two])->groupBy(['barcode','package_num']);

        $pages = new Pagination(['totalCount' => $productModel_three->count()]);
        $pages->setCurPage($page);
        $pages->setPageSize($pageSize);
        $pagination = $pages;

        $productArray = $productModel_three->offset(($page-1)*$pageSize)->limit($pageSize)->asArray()->all();

        $products = (new ProductHelper())->initWithProductArray($productArray,$customer->getCity())
            ->getTags()->getData();

        $result['product_list'] = $products;

        if($pagination){
            $result['pages'] =  [
                'total_count' => $pagination->getTotalCount(),
                'page'        => $pagination->getCurPage(),
                'last_page'   => $pagination->getLastPageNumber(),
                'page_size'   => $pagination->getPageSize(),
            ];
        }

//        Tools::log($productModel_three->createCommand()->getRawSql(),'wangyang.log');
        Tools::log($result,'wangyang.log');
        $response = self::response();
        $response->setFrom(Tools::pb_array_filter($result));
        return $response;
    }

    public static function request()
    {
        return new searchProductRequest();
    }

    public static function response()
    {
        return new searchProductResponse();
    }
}