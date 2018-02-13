<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\UnknownDevice */

$this->title = 'Create Unknown Device';
$this->params['breadcrumbs'][] = ['label' => 'Unknown Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unknown-device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
