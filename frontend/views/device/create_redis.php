<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\DeviceConfig */

//$this->registerJsFile('@frontend_base/web/js/create_redis.js',['position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/create_redis.js',[ 'depends' => 'yii\web\JqueryAsset' ]);

$this->title = '添加设备';
$this->params['breadcrumbs'][] = ['label' => '设备列表(redis)', 'url' => ['index_redis']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_redis', [
        'model' => $model,
    ]) ?>

    <hr/>
    <p>用户ID辅助查询工具</p>
    <p>
        手机号：<input title="手机号" name="kwd" value="" id="kwd"/>
        <button id="query">查询</button>
    </p>
    <pre id="pre">用户信息</pre>

</div>
