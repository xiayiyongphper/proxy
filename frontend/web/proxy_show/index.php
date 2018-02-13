<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/11
 * Time: 11:13
 */

function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

// 获取请求
$request = file_get_contents('php://input');
$request_json = json_decode($request, true);

// 获得文件名
$fileName = md5($request).'.txt';
$response = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$fileName);

header('Content-Type: application/json; charset=utf-8');
$json = json_encode(unserialize($response), true);
//$json = stripslashes(preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $json));

$name = '\u65b0\u6d6a\u5fae\u535a';
$json = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $json);
//$json = stripslashes($json);

echo $json;

//unlink('var/proxy/'.$fileName);