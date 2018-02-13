<?php
namespace framework\components\es;

use Elasticsearch\ClientBuilder;
use framework\components\ToolsAbstract;

/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-6
 * Time: 下午12:19
 */
abstract class EsAbstract implements EsInterface
{
    protected $index;
    protected $type;
    protected $number_of_shards = 5;
    protected $number_of_replicas = 1;
    protected $properties_mapping;
    protected $flag = false;
    const MAX_HANDLES = 5;
    const ES_LEVEL_INFO = 1;
    const ES_LEVEL_DEBUG = 2;
    const ES_LEVEL_NOTICE = 3;
    const ES_LEVEL_WARNING = 4;
    const ES_LEVEL_ERROR = 5;

    public function getType()
    {
        return $this->type;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function createIndex()
    {
        $hosts = [
            '172.16.10.205:9200',
            '172.16.10.111:9200',
            '172.16.10.238:9200',
            '172.16.10.239:9200',
            '172.16.10.240:9200',
        ];
        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
        $params = [
            'index' => $this->index,
            'body' => [
                'settings' => [
                    'number_of_shards' => $this->number_of_shards,
                    'number_of_replicas' => $this->number_of_replicas
                ],
                'mappings' => [
                    "_default_" => [
                        "_timestamp" => [
                            "enabled" => true,
                        ]
                    ],
                    $this->type => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => $this->properties_mapping
                    ]
                ]
            ]
        ];
        $response = $client->indices()->create($params);
        print_r($response);
    }

    public function send($body, $index = null, $type = null)
    {
        try {
            $params = [
                'index' => is_null($index) ? $this->getIndex() : $index,
                'type' => is_null($type) ? $this->getType() : $type,
                'body' => $body
            ];
            if (!$this->flag) {
                if (!file_exists(ToolsAbstract::getESConsolePath())) {
                    mkdir(ToolsAbstract::getESConsolePath(), 0777, true);
                }
                $this->flag = true;
            }
            $file = sprintf('%s%s.bin', ToolsAbstract::getESConsolePath() . DIRECTORY_SEPARATOR, date('YmdHi'));
            file_put_contents($file, json_encode($params) . PHP_EOL, FILE_APPEND);
        } catch (\Exception $e) {
            ToolsAbstract::logException($e);
        }
    }

    public function getTraceId()
    {
        return str_replace('.', '', uniqid(ToolsAbstract::getSysName() . '_', true));
    }
}