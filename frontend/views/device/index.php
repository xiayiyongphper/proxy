<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '设备列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-config-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加设备', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'device_id',
            'charles',
            'environment',
            'is_capture',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
