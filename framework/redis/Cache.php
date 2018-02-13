<?php
namespace framework\redis;
use framework\components\ToolsAbstract;
use yii\base\Component;
use Yii;
/**
 * Class Light_Redis
 * @method array hGetAll($key)
 * @method array hVals($key)
 * @method bool psetex($key, $ttl, $value)
 * @method array|bool sScan($key, $iterator, $pattern = '', $count = 0)
 * @method array|bool scan($iterator, $pattern = '', $count = 0)
 * @method array|bool zScan($key, $iterator, $pattern = '', $count = 0)
 * @method array hScan($key, $iterator, $pattern = '', $count = 0)
 * @method string|bool get($key)
 * @method bool set($key, $value, $timeout = 0)
 * @method bool setex($key, $ttl, $value)
 * @method bool setnx($key, $value)
 * @method int del($key1, $key2 = null, $key3 = null)
 * @method int delete($key1, $key2 = null, $key3 = null)
 * @method bool exists($key)
 * @method int incr($key)
 * @method float incrByFloat($key, $increment)
 * @method int incrBy($key, $value)
 * @method int decr($key)
 * @method int decrBy($key, $value)
 * @method array getMultiple(array $keys)
 * @method int lPush($key, $value1, $value2 = null, $valueN = null)
 * @method int rPush($key, $value1, $value2 = null, $valueN = null)
 * @method int lPushx($key, $value)
 * @method int rPushx($key, $value)
 * @method string lPop($key)
 * @method string rPop($key)
 * @method array blPop(array $keys)
 * @method array brPop(array $keys)
 * @method int lLen($key)
 * @method int lSize($key)
 * @method string lIndex($key, $index)
 * @method string lGet($key, $index)
 * @method bool lSet($key, $index, $value)
 * @method array lRange($key, $start, $end)
 * @method array lGetRange($key, $start, $end)
 * @method array lTrim($key, $start, $stop)
 * @method array listTrim($key, $start, $stop)
 * @method int lRem($key, $value, $count)
 * @method int lRemove($key, $value, $count)
 * @method int lInsert($key, $position, $pivot, $value)
 * @method int sAdd($key, $value1, $value2 = null, $valueN = null)
 * @method int sRem($key, $member1, $member2 = null, $memberN = null)
 * @method int sRemove($key, $member1, $member2 = null, $memberN = null)
 * @method bool sMove($srcKey, $dstKey, $member)
 * @method bool sIsMember($key, $value)
 * @method bool sContains($key, $value)
 * @method int sCard($key)
 * @method string sPop($key)
 * @method string sRandMember($key)
 * @method array sInter($key1, $key2, $keyN = null)
 * @method sInterStore($dstKey, $key1, $key2, $keyN = null)
 * @method sUnion($key1, $key2, $keyN = null)
 * @method sUnionStore($dstKey, $key1, $key2, $keyN = null)
 * @method sDiff($key1, $key2, $keyN = null)
 * @method sDiffStore($dstKey, $key1, $key2, $keyN = null)
 * @method sMembers($key)
 * @method sGetMembers($key)
 * @method getSet($key, $value)
 * @method randomKey()
 * @method select($dbindex)
 * @method move($key, $dbindex)
 * @method rename($srcKey, $dstKey)
 * @method renameKey($srcKey, $dstKey)
 * @method renameNx($srcKey, $dstKey)
 * @method expire($key, $ttl)
 * @method pExpire($key, $ttl)
 * @method setTimeout($key, $ttl)
 * @method expireAt($key, $timestamp)
 * @method pExpireAt($key, $timestamp)
 * @method type($key)
 * @method append($key, $value)
 * @method getRange($key, $start, $end)
 * @method substr($key, $start, $end)
 * @method setRange($key, $offset, $value)
 * @method strlen($key)
 * @method getBit($key, $offset)
 * @method setBit($key, $offset, $value)
 * @method bitCount($key)
 * @method bitOp($operation, $retKey, $key1, $key2, $key3 = null)
 * @method sort($key, $option = null)
 * @method int ttl($key)
 * @method int pttl($key)
 * @method bool persist($key)
 * @method bool mset(array $array)
 * @method array mget(array $array)
 * @method int msetnx(array $array)
 * @method string rpoplpush($srcKey, $dstKey)
 * @method string brpoplpush($srcKey, $dstKey, $timeout)
 * @method zAdd($key, $score1, $value1, $score2 = null, $value2 = null, $scoreN = null, $valueN = null)
 * @method zRange($key, $start, $end, $withscores = null)
 * @method zRem($key, $member1, $member2 = null, $memberN = null)
 * @method int zDelete($key, $member1, $member2 = null, $memberN = null)
 * @method array zRevRange($key, $start, $end, $withscore = null)
 * @method array zRangeByScore($key, $start, $end, array $options = array())
 * @method array zRevRangeByScore($key, $start, $end, array $options = array())
 * @method zCount($key, $start, $end)
 * @method zRemRangeByScore($key, $start, $end)
 * @method zDeleteRangeByScore($key, $start, $end)
 * @method zRemRangeByRank($key, $start, $end)
 * @method zDeleteRangeByRank($key, $start, $end)
 * @method zCard($key)
 * @method zSize($key)
 * @method zScore($key, $member)
 * @method zRank($key, $member)
 * @method zRevRank($key, $member)
 * @method zIncrBy($key, $value, $member)
 * @method zUnion($Output, $ZSetKeys, array $Weights = null, $aggregateFunction = 'SUM')
 * @method zInter($Output, $ZSetKeys, array $Weights = null, $aggregateFunction = 'SUM')
 * @method hSet($key, $hashKey, $value)
 * @method hSetNx($key, $hashKey, $value)
 * @method string hGet($key, $hashKey)
 * @method int hLen($key)
 * @method int hDel($key, $hashKey1, $hashKey2 = null, $hashKeyN = null)
 * @method array hKeys($key)
 * @method bool hExists($key, $hashKey)
 * @method int hIncrBy($key, $hashKey, $value)
 * @method float hIncrByFloat($key, $field, $increment)
 * @method bool hMset($key, $hashKeys)
 * @method array hMGet($key, $hashKeys)
 *
 */
class Cache extends Component
{
    /**
     * host
     * @var string
     */
    protected $_host;
    /**
     * port
     * @var int
     */
    protected $_port;
    /**
     * redis
     * @var \Redis
     */
    protected $_redis = null;

    public $options;
    /**
     * @var $this
     */
    protected static $_instance;

    public function init()
    {
        if (is_array($this->options)) {
            if ( !extension_loaded('redis') ) {
                throw new \Exception('Redis extension not loaded');
            }
            $options = $this->options;
            if (!isset($options['host']) || !$options['host']) {
                throw new \Exception('Redis host undefined.');
            }
            if (!isset($options['port']) || !$options['port']) {
                throw new \Exception('Redis port undefined.');
            }
            $this->_host = $options['host'];
            $this->_port = $options['port'];
        }else{
            throw new \Exception("Cache::redis must be either a Redis connection instance or the application component ID of a Redis connection.");
        }
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        if (!$this->_redis) {
            try {
                $this->_redis = new \Redis();
                $this->_redis->connect($this->_host, $this->_port);
            } catch (\Exception $e) {
                ToolsAbstract::logException($e);
                $this->_redis = null;
            }
        }
        return $this->_redis;
    }

    public static function gzdeflate($data, $level = 9)
    {
        return gzdeflate($data, $level);
    }

    public static function gzinflate($data)
    {
        return gzinflate($data);
    }

    public function __call($funcName, $arguments)
    {
        $result = false;
        try {
            if ($this->_redis) {
                $result = call_user_func_array(array($this->_redis, $funcName), $arguments);
            }
        } catch (\Exception $e) {
            ToolsAbstract::logException($e);
        }
        return $result;
    }
}
