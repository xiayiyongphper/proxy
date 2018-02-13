<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DeviceConfig */

$this->title = '修改设备: ' . ' ' . $model->customer_id;
$this->params['breadcrumbs'][] = ['label' => '设备列表(redis)', 'url' => ['index_redis']];
$this->params['breadcrumbs'][] = ['label' => '用户id', 'url' => ['view', 'customer_id' => $model->customer_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="device-config-update">

    <h1><?= Html::encode($model->customer_id) ?></h1>

    <?= $this->render('_form_redis', [
        'model' => $model,
    ]) ?>

</div>
