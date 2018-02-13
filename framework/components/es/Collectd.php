<?php
namespace framework\components\es;
/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-6
 * Time: 下午12:15
 */
class Collectd extends EsAbstract
{
    protected $index = '.collectd';
    protected $type = 'es_collectd';
    protected static $instance;
    protected $properties_mapping = [
        'host' => [
            'type' => 'string',
        ],
        'ip' => [
            'type' => 'ip',
        ],
        'source' => [
            'type' => 'string',
        ],
        'metric' => [
            'type' => 'string'
        ],
        'value' => [
            'type' => 'float',
        ],
        'tags' => [
            'type' => 'string',
        ],
        'timestamp' => [
            'type' => 'date',
            "format" => "yyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis"
        ],
    ];

    /**
     * @return $this
     */
    public static function get()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function report($metric, $value, $tags = [])
    {
        $this->send([
            'host' => ENV_SERVER_IP,
            'ip' => ENV_SERVER_IP,
            'source' => ENV_SYS_NAME,
            'metric' => $metric,
            'value' => $value,
            'tags' => $tags,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        return true;
    }
}