<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\JsoneditorAsset::register($this);

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .columnNone{max-width: 0;padding: 0;text-indent: -9999px;border:none;}
</style>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('清空所有', ['empty_redis'], ['class' => 'btn btn-danger', 'onclick'=>'javascript:return(confirm("确定要删除吗？"))']) ?>

        请选择查看的设备:
        <?php //Html::a(Yii::t('app', 'Create Log'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php
            $searchParam = Yii::$app->request->getQueryParam('LogSearch');
            $redis = \service\components\Tools::getRedis();
            $optionArray = $redis->hGetAll('debug_device_table');
            if($optionArray){
				foreach ($optionArray as $customer_id => $level) {
					$optionArray[$customer_id] = $customer_id;
				}
            }else{
				$optionArray = [];
            }
            //$optionArray = \frontend\models\DeviceConfig::getOptionArray();
            $optionArray = [0=>'所有'] + $optionArray;
            if(isset($searchParam['customer_id'])){
                $customer_id = $searchParam['customer_id'];
            }else{
                $customer_id = 0;
            }
            echo Html::dropDownList('changeDevice', $customer_id, $optionArray, [
                'onchange' => 'javascript:changeDevice(this)',
                'style'=>''
            ]);
        ?>
		<?= Html::a('清空当前', ['empty_redis', 'id'=>$customer_id], ['class' => 'btn btn-warning']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
			'id',
            'customer_id',
            'response_code',
            'route',
            'created_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<script type="application/javascript">
    function changeDevice(obj){
        var customer_id = obj.value;
        //if(deviceId){
            $('input[name="LogSearch[customer_id]"]').val(customer_id).change();
        //}
    }
</script>