<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 18:31
 */
namespace service\resources\merchant\v1;

use common\models\Brand;
use common\models\HomePageFeatured;
use common\models\LeBanner;
use common\models\LeMerchantProductList;
use common\models\LeMerchantStoreCategory;
use framework\components\Date;
use service\components\Proxy;
use service\components\Redis;
use service\components\Tools;
use service\message\core\HomeRequest;
use service\message\core\HomeResponse2;
use service\models\ProductHelper;
use service\resources\MerchantResourceAbstract;

class home5 extends MerchantResourceAbstract
{
    protected $_areaId;
    protected $_cityId;
    protected $_customerId;
    protected $_isRemote;
    protected $_platform;
    protected $_wholesalerIds;
    protected $_data = [];
    protected $_configDate = [];
    protected $_wholesalerNames;

    /**
     * @param \ProtocolBuffers\Message $data
     * @return HomeResponse2
     * @throws \Exception
     */
    public function run($data)
    {
        /** @var HomeRequest $request */
        $request = $this->request()->parseFromString($data);

        //接口验证用户
        $customerResponse = $this->_initCustomer($request);
        $this->_areaId = $customerResponse->getAreaId();
        $this->_cityId = $customerResponse->getCity();
        $this->_customerId = $customerResponse->getCustomerId();
        //区域内店铺IDs
        $this->_wholesalerIds = $this->getWholesalerIdsByAreaId($this->_areaId);

        $response = $this->response();
        //无供应商时
        if (count($this->_wholesalerIds) == 0) {
            return $response;
        }
        $this->toArray();
//        Tools::log(Tools::pb_array_filter($this->_data), 'wangyang.log');
        $response->setFrom(Tools::pb_array_filter($this->_data));
//        Tools::log($response->toArray(), 'wangyang.log');

        return $response;
    }

    /**
     * @return mixed
     */
    protected function parseJson()
    {
        $featured = HomePageFeatured::find()->where(['area' => $this->_areaId])
            ->andWhere(['like', 'version', '2.0'])->asArray()->one();
        $json = $featured['content'];
        return json_decode($json, true);
    }


    protected function toArray()
    {
        $key = 'merchant_home_page_v5';
        //APP与PC的首页返回区分
        if (false && $this->getRedisCache()->hExists($key, $this->_areaId)) {
            $this->_data = unserialize($this->getRedisCache()->hGet($key, $this->_areaId));
        } else {
            $this->_configDate = $this->parseJson();
//            Tools::log($this->_configDate,'wangyang.log');
            //最上方banners
            $this->getHomeBanner();
            //最上方banner，下方的banner
            $this->getHomeSecondBanner();
            //三赔入口
            $this->getTag();
            //快捷入口
            $this->getQuickEntryBlock();
            //当日特价等
            $this->getProductBlock();
            //专题
            $this->getTopicBlock();
            //推荐商家
            $this->processStore();
            //推荐品牌
            $this->processBanner();
            $this->getRedisCache()->hSet($key, $this->_areaId, serialize($this->_data));
            $this->getRedisCache()->expire($key, 3600); //1小时缓存过期
        }
    }

    protected function processBanner()
    {
        $brand = isset($this->_configDate['brand']['brand_id']) ? $this->_configDate['brand']['brand_id'] : [];

        if (!is_array($brand) || !$brand) {
            return $this;
        }

        $brands = Brand::find()->where(['entity_id' => $brand])->all();

        $brand_data = [];
        /** @var Brand $one_brand */
        foreach ($brands as $one_brand) {
            $brand_tmp['brand_id'] = $one_brand->entity_id;
            $brand_tmp['name'] = $one_brand->name;
            $brand_tmp['icon'] = $one_brand->icon;
            $brand_data['brands'][] = $brand_tmp;
        }
        $brand_data['sort'] = isset($this->_configDate['brand']['sort']) ? $this->_configDate['brand']['sort'] : self::HOME_BRAND_BLOCK_DEFAULT_SORT;
        $this->_data['brand_block'] = $brand_data;
        Tools::log($brand_data, 'wangyang.log');
        return $this;
    }

    /**
     * 只要区域内有供应商支持三赔，就显示三赔
     */
    protected function getTag()
    {

        if (self::getCompensationWholesalerCountByAreaId($this->_areaId) > 0) {
            $this->_data['tag'] = [
                'text' => '送货慢立即现金赔偿，点击查看',
                'icon' => 'http://assets.lelai.com/assets/secimgs/homepei.png',
                'url' => 'http://assets.lelai.com/assets/h5/security/?aid=' . $this->_areaId,
            ];
        }
    }

    /**
     * getQuickEntryBlock
     * Author Jason Y. wang
     * 首页快捷入口
     * @return $this
     */
    protected function getQuickEntryBlock()
    {
        $quickEntryBlocks = isset($this->_configDate['quick_entry_blocks']) ? $this->_configDate['quick_entry_blocks'] : '';
//        Tools::log($quickEntryBlocks,'wangyang.log');
        if (!$quickEntryBlocks) {
            return $this;
        }
        $quickEntry = isset($quickEntryBlocks['quick_entry']) ? $quickEntryBlocks['quick_entry'] : [];
        $quickEntryBlocksImage = isset($quickEntryBlocks['background_img']) ? $quickEntryBlocks['background_img'] : '';

        if (!$quickEntry) {
            return $this;
        }

        $quickEntries = [];
        foreach ($quickEntry as $quickEntryBlock) {
            $quickEntry['src'] = isset($quickEntryBlock['src']) ? $quickEntryBlock['src'] : '';
            $quickEntry['href'] = isset($quickEntryBlock['href']) ? $quickEntryBlock['href'] : '';
            $quickEntry['title'] = isset($quickEntryBlock['title']) ? $quickEntryBlock['title'] : '';

            $quickEntries[] = array_filter($quickEntry);
        }
        $quick_entry_blocks['quick_entry_blocks'] = $quickEntries;
        //首页快捷入口背景图
        if ($quickEntryBlocksImage) {
            $quick_entry_blocks['background_img']['src'] = $quickEntryBlocksImage;
        }
        $this->_data['quick_entry_module'] = $quick_entry_blocks;
        return $this;
    }


    /**
     * Author Jason Y. wang
     * app中top_banner下方的banner
     * @return $this
     */
    protected function getHomeSecondBanner()
    {
        $date = new Date();
        $now = $date->gmtDate();
        // 返回的
        $banner = array();
        // 加上店铺banner逻辑
        $banners = LeBanner::find()->where(
            [
                'le_banner.position' => 'app_home_second_banner',
                'le_banner.status' => 1,
                'le_banner.type_code' => 'app',
            ]
        )->joinWith('areabanner')
            ->andWhere(['le_area_banner.area_id' => $this->_areaId])
            ->andWhere(['<=', 'start_date', $now])
            ->andWhere(['>=', 'end_date', $now])
            ->orderBy('sort desc');
        //Tools::log($banners->createCommand()->getRawSql(),'wangyang.log');
        $banners = $banners->asArray()->all();
        if (count($banners) > 0) {
            foreach ($banners as $item) {
                $addImg = [
                    'href' => $item['url'],
                    'src' => $item['image'],
                ];
                array_unshift($banner, $addImg);
            }
            $this->_data['second_fixed_banner'] = $banner;
        }
        return $this;
    }

    /**
     * Author Jason Y. wang
     * APP首页BANNER
     * @return $this
     */
    protected function getHomeBanner()
    {
        $date = new Date();
        $now = $date->gmtDate();
        // 返回的
        $banner = array();
        // 加上店铺banner逻辑
        $banners = LeBanner::find()->where(
            [
                'le_banner.position' => 'app_home_banner',
                'le_banner.status' => 1,
                'le_banner.type_code' => 'app',
            ]
        )->joinWith('areabanner')
            ->andWhere(['le_area_banner.area_id' => $this->_areaId])
            ->andWhere(['<=', 'start_date', $now])
            ->andWhere(['>=', 'end_date', $now])
            ->orderBy('sort desc');
        //Tools::log($banners->createCommand()->getRawSql(),'wangyang.log');
        $banners = $banners->asArray()->all();
        if (count($banners) > 0) {
            foreach ($banners as $item) {
                $addImg = [
                    'href' => $item['url'],
                    'src' => $item['image'],
                ];
                array_unshift($banner, $addImg);
            }
        } else {
            // 默认的
            $banner = [
                [
                    'href' => '',
                    'src' => 'http://assets.lelai.com/images/booking/home/banner/1.jpg',
                ]
            ];
        }
        $this->_data['top_fixed_banner'] = $banner;
        return $this;
    }


    protected function getProductBlock()
    {

        $product_blocks = isset($this->_configDate['product_blocks']) ? $this->_configDate['product_blocks'] : '';
        //Tools::log($product_blocks,'wangyang.log');
        if (!$product_blocks) {
            return $this;
        }
        foreach ($product_blocks as $product_block) {
            $block = [];
            $block['subtitle'] = isset($product_block['subtitle']) ? $product_block['subtitle'] : '';
            $block['product_block_title_img']['src'] = isset($product_block['product_block_title_img']) ? $product_block['product_block_title_img'] : '';
            $productIds = isset($product_block['products']) ? $product_block['products'] : '';
            if (!$productIds || count($productIds) == 0) {
                continue;
            }
            $limit = isset($product_block['size']) ? $product_block['size'] : 30;
            $products = (new ProductHelper())->initWithProductIds($productIds, $this->_cityId, $this->_wholesalerIds)
                ->getTags()
                ->getData();
            $block['products'] = array_slice($products, 0, $limit);
            $block['sort'] = isset($product_block['sort']) ? $product_block['sort'] : self::HOME_PRODUCT_BLOCK_DEFAULT_SORT;
            $this->_data['product_blocks'][] = $block;
        }

        return $this;
    }

    protected function getTopicBlock()
    {
        $topicBlocks = isset($this->_configDate['topic_blocks']) ? $this->_configDate['topic_blocks'] : '';
        if (!$topicBlocks) {
            return $this;
        }
        //Tools::log($topicBlocks,'wangyang.log');
        $topics = [];
        foreach ($topicBlocks as $topicBlock) {
            $topicBanners['banner'] = $topicBlock['banner'];
            if (!$topicBanners || count($topicBlock['banner']) == 0) {
                continue;
            }
            $topicBanners['title'] = isset($topicBlock['title']) ? $topicBlock['title'] : '';
            $topicBanners['topic_type'] = isset($topicBlock['topic_type']) ? $topicBlock['topic_type'] : self::HOME_TOPIC_BLOCK_DEFAULT_SORT;
            $topicBanners['sort'] = isset($topicBlock['sort']) ? $topicBlock['sort'] : 0;
            $topics[] = $topicBanners;
        }
        $this->_data['topic_blocks'] = $topics;
        return $this;
    }

    /**
     * Author Jason Y. wang
     * 供应商列表
     * @return $this
     */
    protected function processStore()
    {
        $all_merchant_store_category = LeMerchantStoreCategory::find()->all();
        // 是否按照配置的商家查找
        $store_block_title_img = isset($this->_configDate['store']['image']) ? $this->_configDate['store']['image'] : '';
        $wholesalerCount = isset($this->_configDate['store']['count']) ? $this->_configDate['store']['count'] : self::HOME_STORE_BLOCK_DEFAULT_COUNT;
        $sort = isset($this->_configDate['store']['sort']) ? $this->_configDate['store']['sort'] : self::HOME_STORE_BLOCK_DEFAULT_SORT;

        $recentBuyWholesalerIds = Proxy::getRecentlyBuyWholesalerIds($this->_customerId);

        $recentBuyWholesalers = self::getStoreDetailBrief($recentBuyWholesalerIds, $this->_areaId);

        $merchant_group_collection = [];
        /** @var LeMerchantStoreCategory $one_merchant_store_category */
        foreach ($all_merchant_store_category as $one_merchant_store_category) {
            $merchant_store_category_id = $one_merchant_store_category->entity_id;
            $merchant_group = [];
            //推荐供应商，优先展示白名单供应商
            $recommendWholesalerIds = self::getWhiteListWholesalerIds($this->_areaId, $wholesalerCount, $merchant_store_category_id);
            $recommendWholesalerCount = count($recommendWholesalerIds);
            //数量小于N时，获取最近购买供应商
            if ($recommendWholesalerCount < $wholesalerCount) {
                //将最近购买供应商加入推荐供应商
                foreach ($recentBuyWholesalers as $wholesaler_id => $recentBuyWholesaler) {
                    //判断有没有在配送区域内
                    if (in_array($wholesaler_id, $this->_wholesalerIds)) {
                        //判断是不是已经加入精选供应商
                        if (!in_array($wholesaler_id, $recommendWholesalerIds)) {
                            $recentBuyMerchantCategories = isset($recentBuyWholesaler['store_category']) ? $recentBuyWholesaler['store_category'] : '';
                            //判断分类
                            if ($recentBuyMerchantCategories) {
                                $recentBuyMerchantCategories = array_filter(explode('|', $recentBuyMerchantCategories));
                                if (in_array($one_merchant_store_category, $recentBuyMerchantCategories)) {
                                    array_push($recommendWholesalerIds, $wholesaler_id);
                                }
                            }
                            if (count($recommendWholesalerIds) == $wholesalerCount) {
                                break;
                            }
                        }
                    }
                }
//                Tools::log($recommendWholesalerIds,'wangyang.log');
                //还是小于N个则用普通供应商填充
                if (count($recommendWholesalerIds) < $wholesalerCount) {
                    $commonBuyWholesalers = self::getStoreDetailBrief($this->_wholesalerIds, $this->_areaId);
                    foreach ($commonBuyWholesalers as $wholesaler_id => $commonBuyWholesaler) {

                        if (!in_array($wholesaler_id, $recommendWholesalerIds)) {
                            $commonMerchantCategories = isset($commonBuyWholesaler['store_category']) ? $commonBuyWholesaler['store_category'] : '';
                            //判断分类
                            if ($commonMerchantCategories) {
                                $commonMerchantCategories = array_filter(explode('|', $commonMerchantCategories));
                                if (in_array($merchant_store_category_id, $commonMerchantCategories)) {
                                    array_push($recommendWholesalerIds, $wholesaler_id);
                                }
                            }

                            if (count($recommendWholesalerIds) == $wholesalerCount) {
                                break;
                            }
                        }
                    }
                }
            }
//            Tools::log($recommendWholesalerIds,'wangyang.log');
            $wholesalers = self::getStoreDetailBrief($recommendWholesalerIds, $this->_areaId);
            $merchant_group['store_list'] = $wholesalers;
            $merchant_group['category'] = $one_merchant_store_category->name;
            $merchant_group_collection[] = $merchant_group;
        }
        $store_block['store_group'] = $merchant_group_collection;
        //全部店铺数量
        $store_block['store_count'] = count($this->_wholesalerIds);
        //排序
        if ($sort) {
            $store_block['sort'] = $sort;
        }
        //block上方图片
        if ($store_block_title_img) {
            $store_block['store_block_title_img']['src'] = $store_block_title_img;
        }

        $this->_data['store_block'] = $store_block;

        return $this;
    }

    /**
     * @return \framework\redis\Cache
     */
    protected function getRedisCache()
    {
        return \Yii::$app->redisCache;
    }

    public static function request()
    {
        return new HomeRequest();
    }

    public static function response()
    {
        return new HomeResponse2();
    }

}