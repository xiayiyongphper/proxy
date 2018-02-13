<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\DeviceConfig */

$this->title = $model->customer_id;
$this->params['breadcrumbs'][] = ['label' => '设备列表(redis)', 'url' => ['index_redis']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-config-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update_redis', 'id' => $model->customer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete_redis', 'id' => $model->customer_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'customer_id',
            'level',
        ],
    ]) ?>

</div>
