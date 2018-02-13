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
        <?= Html::a('清空列表', ['empty'], ['class' => 'btn btn-danger']) ?>

        请选择查看的设备:
        <?php //Html::a(Yii::t('app', 'Create Log'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php
            $searchParam = Yii::$app->request->getQueryParam('LogSearch');
            $optionArray = \frontend\models\DeviceConfig::getOptionArray();
            $optionArray = [0=>'所有'] + $optionArray;
            if(isset($searchParam['device_id'])){
                $deviceId = $searchParam['device_id'];
            }else{
                $deviceId = 0;
            }
            echo Html::dropDownList('changeDevice', $deviceId, $optionArray, [
                'onchange' => 'javascript:changeDevice(this)',
                'style'=>'font-size:22px;'
            ]);
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            //'device_id',
            [
                'class' => 'yii\grid\DataColumn', // this line is optional
                'attribute' => 'device_id',
                'filterOptions'=>['class'=>'columnNone','style'=>'max-width: 0;padding: 0;text-indent: -9999px;border:none;overflow: hidden;'],
                'headerOptions'=>['class'=>'columnNone','style'=>'max-width: 0;padding: 0;text-indent: -9999px;border:none;overflow: hidden;'],
                'contentOptions'=>['class'=>'columnNone','style'=>'max-width: 0;padding: 0;text-indent: -9999px;border:none;overflow: hidden;'],
            ],
            //[
            //    'class' => 'yii\grid\DataColumn', // this line is optional
            //    'attribute' => 'route',
            //    'filterOptions'=>['style'=>'max-width: 300px;overflow: hidden;'],
            //    'headerOptions'=>['style'=>'max-width: 300px;overflow: hidden;'],
            //    'contentOptions'=>['style'=>'max-width: 300px;overflow: hidden;'],
            //],

            //'client',
            //'api_remote',
            //'charles',
            //'proxy_show',
            //'request:ntext',
            //'response:ntext',
            //[
            //    'class' => 'frontend\views\render\code', // this line is optional
            //    'attribute' => 'response',
            //    'contentOptions'=>['style'=>'padding: 0;'],
            //],
            //[
            //    'class' => 'frontend\views\render\code', // this line is optional
            //    'attribute' => 'response',
            //    'contentOptions'=>['style'=>'padding: 0;'],
            //],

            [
                'class' => 'frontend\views\render\url_encode', // this line is optional
                'attribute' => 'request',
                'contentOptions'=>['class'=>'jsonEditor','style'=>'max-width: 300px;padding:0;overflow: hidden;'],
            ],
            [
                'class' => 'frontend\views\render\url_encode', // this line is optional
                'attribute' => 'response',
                'contentOptions'=>['class'=>'jsonEditor','style'=>'max-width: 300px;padding:0;overflow: hidden;'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<script type="application/javascript">
    function changeDevice(obj){
        var deviceId = obj.value;
        //if(deviceId){
            $('input[name="LogSearch[device_id]"]').val(deviceId).change();
        //}
    }
</script>