<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\DeviceConfig */

$this->title = '添加设备';
$this->params['breadcrumbs'][] = ['label' => '设备列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
