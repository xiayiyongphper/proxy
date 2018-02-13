<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Log */
/* @var $form yii\widgets\ActiveForm */

\frontend\assets\JsoneditorAsset::register($this);

?>

<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'api_remote')->textInput(['maxlength' => true]) ?>

    <label class="control-label" for="log-request">Request</label>
    <div class="jsonEditor"><?= urlencode($model->request); ?></div>

    <label class="control-label" for="log-response">Response</label>
    <div class="jsonEditor"><?= urlencode($model->response); ?></div>

    <?php //$form->field($model, 'request')->textarea(['rows' => 6]) ?>

    <?php //$form->field($model, 'response')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'charles')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proxy_show')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
