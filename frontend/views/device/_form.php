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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'device_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charles')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'environment')->dropDownList($eviroments) ?>

    <?= $form->field($model, 'is_capture')->dropDownList([
        '0'=>'不抓包,仅重定向测试环境',
        '1'=>'抓包',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
