<?php

namespace service\components\search;
use MongoDB\BSON\Serializable;
use service\components\Tools;
use service\message\merchant\searchProductRequest;
use service\resources\MerchantResourceAbstract;

/**
 * Created by Jason.
 * Author: Jason Y. Wang
 * Date: 2016/4/15
 * Time: 16:09
 */
class SphinxSearch extends Search
{

    private $source = [
        '440300' => 'product_440300_main',
        '441800' => 'product_441800_main',
    ];

    /**
     * Function: search
     * Author: Jason Y. Wang
     * 搜索功能
     * @return mixed
     */
    public function search()
    {
        $keyword = $this->searchRequest->getKeyword();
        $wholesaler_id = $this->searchRequest->getWholesalerId();
        $customer = $this->customer;
        /** 搜索引擎 Client */
        $sphinx = new \SphinxClient();
        $sphinx->setServer('127.0.0.1', 9322);

        //先进行分词，然后用分词查询
        if($keyword){
            $words = $this->prepare($sphinx,$keyword,$this->source[$customer->getCity()]);
            Tools::log($words, 'wangyang.txt');
        }

        //设置匹配模式
        $sphinx->setMatchMode(SPH_MATCH_EXTENDED2);
       // $sphinx->setMatchMode(SPH_MATCH_ALL);
//        $sphinx->setMatchMode(SPH_MATCH_ANY);
        //如果不设置，则默认为20条结果
        $sphinx->setLimits(0,1000,1000);
        $sphinx->setMaxQueryTime(30);
        //状态过滤 审核通过且上架
        $sphinx->SetFilter('status',array(1));
        $sphinx->SetFilter('state',array(2));
        //商家过滤
        if ($wholesaler_id > 0) {
            // 查指定的商家
            $sphinx->SetFilter('wholesaler_id',array($wholesaler_id));
        } else{
            // 否则就查该区域的商家id
            $wholesalerIdList = MerchantResourceAbstract::getAreaWholesalers($customer->getAreaId());
            $sphinx->SetFilter('wholesaler_id',array_column($wholesalerIdList, 'wholesaler_id'));
        }

        ////匹配表达式，在名称和品牌中搜索
        //大于4位纯数字搜索条码
        if(is_numeric($keyword) && $keyword > 1000){
            $res = $sphinx->query("@barcode {$keyword}",$this->source[$customer->getCity()]);
        }else{
            if(!$keyword){
                $res = $sphinx->query("",$this->source[$this->customer->getCity()]);
            }else{
                $res = $sphinx->query("@(name,brand,package_num,package_spe,package,specification) {$words}",$this->source[$customer->getCity()]);
            }
        }

//        if(!$keyword){
//            $keyword = '';
//        }
//        $res = $sphinx->query($keyword,$this->source[$customer->getCity()]);
        Tools::log($res, 'wangyang.txt');
        $product_ids = [];
        if(isset($res['matches']) && count($res['matches'])) {
            $product_ids = array_keys($res['matches']);
        }
        return $this->packagingResponse($product_ids);
    }

    /**
     * Function: prepare
     * Author: Jason Y. Wang
     * 先进行分词
     * @param $sphinx
     * @param $keyword
     * @param $index
     * @return array|string
     * @internal param $query
     */
    private function prepare($sphinx,$keyword,$index)
    {
        $keywords = $sphinx->buildKeywords($keyword, $index, false);
        $query = array();
        foreach ($keywords as $key) {
            $query[] = $key["tokenized"];
        }
        $query = implode("|", $query);
        return $query;
    }

}