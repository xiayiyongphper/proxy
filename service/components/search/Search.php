<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/4/15
 * Time: 16:18
 */

namespace service\components\search;


use common\data\Pagination;
use common\models\Products;
use service\components\Tools;
use service\message\customer\CustomerResponse;
use service\message\merchant\searchProductRequest;
use service\message\merchant\searchProductResponse;
use service\resources\MerchantResourceAbstract;
use yii\db\Expression;

class Search extends SearchAbstract implements SearchInterface
{
    /**
     * Search constructor.
     * @param CustomerResponse $customer
     * @param searchProductRequest $searchRequest
     */
    public function __construct($customer,$searchRequest)
    {
        $this->customer = $customer;
        $this->searchRequest = $searchRequest;
    }

    /**
     * Function: search
     * Author: Jason Y. Wang
     * 搜索功能
     * @return mixed
     */
    public function search()
    {
        // TODO: Implement search() method.
    }

    /**
     * Function: packagingResponse
     * Author: Jason Y. Wang
     *
     * @param $product_ids
     * @return searchProductResponse
     */
    public function packagingResponse($product_ids)
    {
        /** @var searchProductRequest $request */
        $request = $this->searchRequest;
        /** @var CustomerResponse $customer */
        $customer = $this->customer;
        $conditions = ['in','entity_id',$product_ids];
        //全部商品分类
        $productModel = new Products($customer->getCity());
        $categoryQuery = $productModel->find()
            ->select(['third_category_id', 'second_category_id', 'first_category_id'])
            ->where($conditions)
            ->groupBy(['third_category_id', 'second_category_id', 'first_category_id'])
            ->asArray()
            ->all();
        $pmsCategory = Tools::getCategoryByProducts($categoryQuery);
        //通过分类过滤商品
        $categoryId = $this->searchRequest->getCategoryId();
        $categoryLevel = $this->searchRequest->getCategoryLevel()?:Tools::getCategoryLevelByID($categoryId);
        if ($categoryId) {
            switch ($categoryLevel) {
                case 1:
                    $category = 'first_category_id';
                    break;
                case 2:
                    $category = 'second_category_id';
                    break;
                case 3:
                    $category = 'third_category_id';
                    break;
                default :
                    $category = 'third_category_id';
                    break;
            }
            $conditions = ['and',$conditions,[$category=>$categoryId]];
        }

        // 品牌
        $brand = $request->getBrand();
        if ($brand) {
            $conditions = ['and', $conditions,
                ['like', 'brand', $brand],
            ];
        }

        $order_by = $this->order($request,$product_ids);
        $productModel = new Products($this->customer->getCity());
        $productList = $productModel->find()
            ->where($conditions)
            ->orderBy($order_by);
        // 分页
        $page = $request->getPage() ? $request->getPage() : 1;
        $pageSize = $request->getPageSize() ? $request->getPageSize() : 20;
        $countQuery = clone $productList;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setCurPage($page);
        $pages->setPageSize($pageSize);
        $productList = $productList->offset($pages->getOffset())
            ->limit($pages->getLimit())
            ->all();

        $product = [];
        if ($productList && count($productList)) {
            foreach ($productList as $item) {
                $data = MerchantResourceAbstract::getProductDetailArray($item);
                array_push($product, array_filter($data));
            }
        }

        $result = [
            'product_list' => $product,
            'pages'        => [
                'total_count' => $pages->getTotalCount(),
                'page'        => $pages->getCurPage(),
                'last_page'   => $pages->getLastPageNumber(),
                'page_size'   => $pages->getPageSize(),
            ],
            'category' => $pmsCategory,
            'sql'=>$sql,
        ];

        $response = new searchProductResponse();
        $response->setFrom(array_filter($result));

        return $response;
    }

    /**
     * Function: order
     * Author: Jason Y. Wang
     *
     * @param searchProductRequest $request
     * @param array $product_ids
     * @return array|Expression
     */
    protected function order($request,$product_ids){
        // 排序
        $order_by = ['sort_weights' => SORT_DESC];// 默认按权重排序
        $allowedSortField = array('sold_qty', 'price');
        $field = $request->getField();
        if (in_array($field, $allowedSortField)) {
            $sort = $request->getSort() == "asc" ? SORT_ASC : SORT_DESC;
            $order_by = [$field => $sort];
        } else {
            if($request->getKeyword() && count($product_ids)){
                $order = implode(',',$product_ids);
                $order_by = [new Expression("FIELD (`entity_id`,".$order.")")];
            }
        }
        return $order_by;
    }

}