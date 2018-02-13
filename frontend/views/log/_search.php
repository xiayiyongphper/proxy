<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\LogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'device_id') ?>

    <?= $form->field($model, 'route') ?>

    <?= $form->field($model, 'client') ?>

    <?= $form->field($model, 'api_remote') ?>

    <?php // echo $form->field($model, 'charles') ?>

    <?php // echo $form->field($model, 'proxy_show') ?>

    <?php // echo $form->field($model, 'request') ?>

    <?php // echo $form->field($model, 'response') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
