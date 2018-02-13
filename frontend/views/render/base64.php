<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 14/6/16
 * Time: PM2:09
 */

namespace frontend\views\render;

use yii\grid\DataColumn;

class Base64 extends DataColumn
{
	protected function renderDataCellContent($model, $key, $index){
		$org = $this->getDataCellValue($model, $key, $index);
		return base64_encode($org);
	}
}