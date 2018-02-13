<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = '环境列表';
$eviroment_list = Yii::$app->params['proxy'];

?>
<div class="site-environment">
    <h1><?= Html::encode($this->title) ?></h1>
    <pre><?php echo print_r($eviroment_list, true); ?></pre>
</div>
