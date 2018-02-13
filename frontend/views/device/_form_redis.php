<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\DeviceConfig */
/* @var $form yii\widgets\ActiveForm */

$eviroment_list = array_keys(Yii::$app->params['proxy']);
$eviroments = [];
foreach ($eviroment_list as $eviroment) {
    $eviroments[$eviroment] = $eviroment;
}
?>

<div class="device-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
