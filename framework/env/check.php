<?php

/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-25
 * Time: 下午2:03
 * Email: henryzxj1989@gmail.com
 */
require_once __DIR__.'/../../common/config/env.php';
require_once __DIR__.'/../../common/config/functions.php';

class EnvCheck
{
    protected $lineLen = 43;
    protected $entities;
    protected $file = 'env.ini';
    protected $patterns = [
        'sys' => '/^(core|customer|merchant|route)$/',
        'ip' => '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',
        'number' => '/^\d+$/',
        'string' => '/^\S+$/',
    ];

    public function __construct()
    {
        $file = __DIR__ . DIRECTORY_SEPARATOR . $this->file;
        if (!file_exists($file)) {
            throw new \Exception('INI File not existed!');
        }
        $this->entities = parse_ini_file($file, true);
        $this->checkAll();
    }

    protected function checkAll()
    {
        foreach ($this->entities as $method => $entity) {
            switch ($method) {
                case 'defined':
                    $this->checkDefined($entity);
                    break;
                case 'extension_loaded':
                    $this->checkExtensionLoaded($entity);
                    break;
            }
        }
    }

    protected function checkDefined($entity)
    {
        $this->output_header_row('check required env');
        foreach ($entity as $key => $p) {
            if (defined($key)) {
                $pattern = $this->patterns[$p];
//                echo constant($key).PHP_EOL;
//                echo $pattern.PHP_EOL;
                $flag = preg_match($pattern, constant($key));
                $this->output_data_row($key, $flag ? 'ok' : 'invalid');
            } else {
                $this->output_data_row($key, 'fail');
            }
        }
    }

    protected function checkExtensionLoaded($entity)
    {
        $this->output_header_row('check php extension loaded');
        foreach ($entity as $key => $pattern) {
            $this->output_data_row($key, extension_loaded($key) ? 'ok' : 'fail');
        }
    }

    public function output_data_row($key, $value)
    {
        echo sprintf("|%-35s|%-5s|%s", $key, $value, PHP_EOL);
        echo sprintf('%s%s', str_repeat('-', $this->lineLen), PHP_EOL);
    }

    public
    function output_header_row($title)
    {
        echo sprintf('%s%s', str_repeat('-', $this->lineLen), PHP_EOL);
        echo sprintf('|%-41s|%s', strtoupper($title), PHP_EOL);
        echo sprintf('%s%s', str_repeat('-', $this->lineLen), PHP_EOL);
    }
}

new EnvCheck();