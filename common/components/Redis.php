<?php

namespace common\components;
use Yii;

/**
 * Author: Jason Y. Wang
 * Class Redis
 * @package common\components
 */
class Redis
{
    /**
     * @return \yii\redis\Cache
     */
    public static function getRedis()
    {
        return Yii::$app->redisCache;
    }

}