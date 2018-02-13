<?php
namespace framework\components;

use framework\data\Pagination;

/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-26
 * Time: 下午2:45
 * Email: henryzxj1989@gmail.com
 */
abstract class ToolsAbstract
{
    /**
     * filter
     * Author Jason Y. wang
     * pb数据赋值前去掉null和null字符串
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public static function pb_array_filter($data)
    {
        if (!is_array($data)) {
            throw new \Exception('传入参数不是数组', 9999);
        }
        foreach ($data as $key => $b) {
            if (is_array($b)) {
                $result = self::pb_array_filter($b);
                if (is_array($result) && count($result) > 0) {
                    $data[$key] = $result;
                } else {
                    unset($data[$key]);
                }
            } else {
                if ((is_string($b) && strtolower($b) == 'null') || is_null($b)) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    public static function getLogPath()
    {
        return \Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'logs';
    }

    public static function getESConsolePath()
    {
        return self::getLogPath() . DIRECTORY_SEPARATOR . '.es_console';
    }

    public static function getLogFilename($file)
    {
        $file = empty($file) ? 'system.log' : $file;
        $parts = explode('.', $file);
        $ext = array_pop($parts);
        array_push($parts, date('Y-m-d'));
        array_push($parts, $ext);
        $file = implode('.', $parts);
        return $file;
    }

    /**
     * @param $table
     * @param $attributes
     * @param $elapsed
     * @return bool
     */
    public static function report($table, $attributes, $elapsed)
    {
        $logFile = 'php-system.log';
        try {
            if (!isset($table, $elapsed, $attributes)) {
                return false;
            }
            $influxDb = \Yii::$app->params['influx_db'];
            $host = isset($influxDb['host']) ? $influxDb['host'] : 'localhost';
            $port = isset($influxDb['port']) ? $influxDb['port'] : '8086';
            $db = isset($influxDb['db']) ? $influxDb['db'] : 'mydb';
            $attrString = '';
            if (is_string($attributes)) {
                $attrString = $attributes;
            }
            if (is_array($attributes) && count($attributes) > 0) {
                $data = [];
                foreach ($attributes as $key => $value) {
                    if (isset($key, $value) && strlen($value) > 0) {
                        $data[] = "$key=$value";
                    }
                }
                $attrString = implode(',', $data);
            }
            $cmd = "curl -s -X POST 'http://{$host}:{$port}/write?db={$db}&precision=s' --data-binary '{$table},{$attrString} value={$elapsed}'";
            self::log($cmd, $logFile);
            system($cmd);
        } catch (\Exception $e) {
            self::logException($e);
        }
        return true;
    }

    public static function log($data, $filename = null)
    {
        if (!$filename) {
            $filename = 'system.log';
        }
        $filename = self::getLogFilename($filename);
        $date = new Date();
        $file = self::getLogPath() . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($file, '[' . $date->date() . '] ' . print_r($data, true) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param \Exception $e
     * @param null $filename
     */
    public static function logException($e, $filename = null)
    {
        if (!$filename) {
            $filename = 'exception.log';
        }
        $filename = self::getLogFilename($filename);
        $date = new Date();
        $file = self::getLogPath() . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($file, '[' . $date->date() . '] ' . $e->__toString() . PHP_EOL, FILE_APPEND);
    }

    public static function logToFile($data, $filename)
    {
        $file = self::getLogPath() . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($file, $data);
    }

    /**
     * @return \framework\redis\Cache
     * @throws \yii\base\InvalidConfigException
     */
    public static function getRedis()
    {
        return \Yii::$app->get('redisCache');
    }

    public static function getSphinx()
    {
        return \Yii::$app->get('sphinx');
    }

    public static function numberFormat($number, $precision = 0)
    {
        return number_format($number, $precision, null, '');
    }

    public static function getSysName()
    {
        return ENV_SYS_NAME;
    }

    /**
     * @param Pagination $pagination
     * @return array
     */
    public static function getPagination($pagination)
    {
        return [
            'total_count' => $pagination->getTotalCount(),
            'page' => $pagination->getCurPage(),
            'last_page' => $pagination->getLastPageNumber(),
            'page_size' => $pagination->getPageSize(),
        ];
    }

    /**
     * @return \framework\mq\RabbitMQ
     * @throws \yii\base\InvalidConfigException
     */
    public static function getMQ()
    {
        return \Yii::$app->get('mq');
    }
}