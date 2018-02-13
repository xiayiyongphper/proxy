<?php
/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/4/15
 * Time: 16:41
 */

namespace service\components\search;


use common\models\Products;
use service\message\merchant\searchProductRequest;
use service\resources\MerchantResourceAbstract;
use yii\helpers\ArrayHelper;

class DateBaseSearch extends Search
{
    public function search()
    {
        /** @var  searchProductRequest  $searchRequest */
        $request = $this->searchRequest;
        $customer = $this->customer;
        // 组装查询条件
        $condition = [];
        // 商家id
        if ($request->getWholesalerId()) {
            // 查指定的商家
            $condition['wholesaler_id'] = $request->getWholesalerId();
        } else {
            // 否则就查该区域的商家id
            $wholesalerIdList = MerchantResourceAbstract::getAreaWholesalers($customer->getAreaId());
            $condition['wholesaler_id'] = array_column($wholesalerIdList, 'wholesaler_id');
        }

        // keyword
        $keyword = $request->getKeyword();
        if ($keyword) {
            $words = array_filter(explode(' ', preg_replace('/\s+/', ' ', trim($keyword))));
            foreach ($words as $word) {
                $condition = ['and', $condition,
                    ['like', 'CONCAT(brand, name, specification, package_spe, package_num, package)', $word],
                ];
            }
        }

        // 品牌
        $brand = $request->getBrand();
        if ($brand) {
            $condition = ['and', $condition,
                ['like', 'brand', $brand],
            ];
        }


        // 商品的必要条件
        $condition['state'] = 2;//通过审核
        $condition['status'] = 1;//上架
        $condition = ['and', $condition,
            ['not', ['brand' => null]]// 品牌不为空
        ];
        $condition = ['and', $condition,
            ['not', ['brand' => '']]// 品牌不为空
        ];

        $productModel = new Products($this->customer->getCity());
        $products = $productModel->find()
            ->select('entity_id')
            ->where($condition)->asArray()->all();
        $product_ids = ArrayHelper::getColumn($products,'entity_id');
        return $this->packagingResponse($product_ids);
    }
}