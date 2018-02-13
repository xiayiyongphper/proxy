<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '设备列表(redis)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-config-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加设备', ['create_redis'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'customer_id',
            'level',

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view_redis} {update_redis} {delete_redis}',
				'buttons' => [
					// 下面代码来自于 yii\grid\ActionColumn 简单修改了下
					'view_redis' => function ($url, $model, $key) {
						$options = [
							'title' => Yii::t('yii', 'View'),
							'aria-label' => Yii::t('yii', 'View'),
							'data-pjax' => '0',
						];
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
					},
					'update_redis' => function ($url, $model, $key) {
						$options = [
							'title' => Yii::t('yii', 'Update'),
							'aria-label' => Yii::t('yii', 'Update'),
							'data-pjax' => '0',
						];
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
					},
					'delete_redis' => function ($url, $model, $key) {
						$options = [
							'title' => Yii::t('yii', 'Delete'),
							'aria-label' => Yii::t('yii', 'Delete'),
							'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
							'data-method' => 'post',
							'data-pjax' => '0',
						];
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
					},
				]
			],
        ],
    ]); ?>

</div>
