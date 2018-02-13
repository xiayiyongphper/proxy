<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 14/6/16
 * Time: PM2:09
 */

namespace frontend\views\render;

use yii\grid\DataColumn;

class Code extends DataColumn
{
	protected function renderDataCellContent($model, $key, $index){
		$org = $this->getDataCellValue($model, $key, $index);
		return base64_encode($org);
		//$org = '{"====================================================":"","api_remote":"121.201.110.245:6000","client":"172.16.10.242","device_id":"f3a040e05418688983b02c347886f0cb","----------------------------------------------------":"","service\\message\\common\\Header":{"version":1,"route":"customers.login","encrypt":1,"protocol":1,"request_id":4,"trace_id":"merchant_575f9bd022f66586095627","source":3,"app_version":"2.0.0","device_id":"f3a040e05418688983b02c347886f0cb"},"service\\message\\customer\\LoginRequest":{"username":"test","password":"e10adc3949ba59abbe56e057f20f883e"}}';
		$value = json_decode($org);
		//print_r($value);exit;
		if($value){
			//$org = print_r($org,true);
			$org = htmlspecialchars($org);
			return '<pre>'.$org.'</pre>';
		}else{
			return $org;
		}

	}
}