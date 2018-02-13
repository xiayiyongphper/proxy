<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/29
 * Time: 14:58
 */
namespace service\components;

use common\models\LeMerchantStore;
use Yii;
use yii\helpers\ArrayHelper;

class Redis
{
    const REDIS_KEY_WHOLESALERS = 'wholesalers';
    const REDIS_KEY_PMS_CATEGORIES = 'pms_categories';
    const REDIS_KEY_CUSTOMERIDS = 'customerids';
    const SOAP_PMS_URL = 'http://pms.laile.com/api/soap?wsdl';

    /**
     * @param $wholesalerId
     * @param $wholesaler
     * @return bool
     */
    public static function setWholesaler($wholesalerId, $wholesaler)
    {
        if (!$wholesalerId) {
            return false;
        }
        $redis = Tools::getRedis();
        $existed = $redis->exists(self::REDIS_KEY_WHOLESALERS);
        $redis->hSet(self::REDIS_KEY_WHOLESALERS, $wholesalerId, $wholesaler);
        if (!$existed) {
            $redis->expire(self::REDIS_KEY_WHOLESALERS, 3600);
        }
    }

    /**
     * 缓存供应商信息
     * @todo setWholesalers([1=>serialize($wholesaler),2=>serialize($wholesaler)])
     * @param $wholesalers
     * @return bool|null
     */
    public static function setWholesalers($wholesalers)
    {
        if (!$wholesalers) {
            return false;
        }
        if (is_array($wholesalers) && count($wholesalers) > 0) {
            $redis = Tools::getRedis();
            $existed = $redis->exists(self::REDIS_KEY_WHOLESALERS);
            $redis->hMSet(self::REDIS_KEY_WHOLESALERS, $wholesalers);
            if (!$existed) {
                $redis->expire(self::REDIS_KEY_WHOLESALERS, 3600);
            }
        }
    }

    /**
     * 根据供应商ID获取供应商信息
     * @todo getWholesalers([1,2,3,4])
     * @param $source
     * @return array|bool|null|string
     */
    public static function getWholesalers($source)
    {
        if (!is_array($source)) {
            $source = [$source];
        }
        $redis = Tools::getRedis();
        $wholesalers = $redis->hMGet(self::REDIS_KEY_WHOLESALERS, $source);
        $wholesalers = array_filter($wholesalers);
        $matched = array();
        if (is_array($wholesalers)) {
            $matched = array_keys($wholesalers);
        }
        $diff = array_diff($source, $matched);
        if (count($diff) > 0) {
            $stores = LeMerchantStore::find()->where(['entity_id' => $diff])->asArray()->all();
            $diffProduct = [];
            foreach ($stores as $store) {
                $diffProduct[$store['entity_id']] = serialize($store);
                $wholesalers[$store['entity_id']] = serialize($store);
            }
            if(count($diffProduct)>0){
                $redis->hMSet(self::REDIS_KEY_WHOLESALERS, $diffProduct);
            }
        }
        return $wholesalers;
    }

    /**
     * 根据供应商ID获取对应的字段
     * @todo getWholesalersColumn([1,2,3,4],'store_name')
     * @param $wholesalerIds
     * @param $column
     * @return array
     */
    public static function getWholesalersColumn($wholesalerIds, $column)
    {
        $values = [];
        if ($wholesalerIds) {
            if (!is_array($wholesalerIds)) {
                $wholesalerIds = [$wholesalerIds];
            }
            $wholesalers = self::getWholesalers($wholesalerIds);
            foreach ($wholesalers as $wholesalerId => $wholesaler) {
                $wholesaler = unserialize($wholesaler);
                if (isset($wholesaler[$column])) {
                    $values[$wholesalerId] = $wholesaler[$column];
                } else {
                    $values[$wholesalerId] = '';
                }
            }
        }
        return $values;
    }

    public static function getPMSCategories($useCache = true)
    {
        $redis = Tools::getRedis();
        if (!$useCache || !$redis->exists(self::REDIS_KEY_PMS_CATEGORIES)) {
            $soapCfg = \Yii::$app->params['pms_soap_cfg'];
            if (isset($soapCfg['url']) && $soapCfg['username'] && $soapCfg['password']) {
                $client = new \SoapClient($soapCfg['url']);
                $sessionId = $client->login($soapCfg['username'], $soapCfg['password']);
                $categories = $client->call($sessionId, 'catalog_category.categories', array());
                /** @var \yii\Redis\Cache $redis */
                $_data = [];
                foreach ($categories as $category) {
                    $_data[$category['id']] = serialize($category);
                }
                $categoryCount = count($_data);
                if ($categoryCount) {
                    $redis->hMSet(self::REDIS_KEY_PMS_CATEGORIES, $_data);
                    $redis->expire(self::REDIS_KEY_PMS_CATEGORIES, 3600);
                    \Yii::trace(sprintf('There is %s categories load from pms', $categoryCount));
                } else {
                    \Yii::trace('There is no categories load from pms');
                }
            } else {
                \Yii::trace('Pms soap config is not set.');
            }
            \Yii::trace(sprintf('Load categories from pms:%s', $soapCfg['url']));
        } else {
            \Yii::trace('Load categories from redis cache');
        }
        return $redis->hGetAll(self::REDIS_KEY_PMS_CATEGORIES);
    }

    /**
     * @param array|int $id
     * @return array
     */
    public static function getCategories($id)
    {
        if (!is_array($id)) {
            $id = [$id];
        }
        $id = array_filter($id);

        if(count($id)==0){
            return false;
        }

        $redis = Tools::getRedis();
        if (!$redis->exists(self::REDIS_KEY_PMS_CATEGORIES)) {
            self::getPMSCategories();
        }
        $categories = $redis->hMGet(self::REDIS_KEY_PMS_CATEGORIES, $id);
        foreach ($categories as $key => $value) {
            $categories[$key] = unserialize($value);
        }
        return $categories;
    }

    /**
     * @param array|int $id
     * @return array
     */
    public static function getCategory($id)
    {
        $redis = Tools::getRedis();
        if (!$redis->exists(self::REDIS_KEY_PMS_CATEGORIES)) {
            self::getPMSCategories();
        }
        $category = $redis->hGet(self::REDIS_KEY_PMS_CATEGORIES, $id);
        return unserialize($category);
    }

    /**
     * @param $wholesalerId
     * @param $wholesaler
     * @return bool
     */
    public static function setCustomerIds($customerIds = null)
    {
        if (!$customerIds || !is_array($customerIds)) {
            return false;
        }
        $redis = Tools::getRedis();
        return $redis->set(self::REDIS_KEY_CUSTOMERIDS, serialize($customerIds));// 不过期
    }

    /**
     * @param $wholesalerId
     * @param $wholesaler
     * @return bool|array
     */
    public static function getCustomerIds()
    {
        $redis = Tools::getRedis();
        $existed = $redis->exists(self::REDIS_KEY_CUSTOMERIDS);
        if(!$existed){
            return false;
        }else{
            $list = $redis->get(self::REDIS_KEY_CUSTOMERIDS);
            return unserialize($list);
        }

    }



}