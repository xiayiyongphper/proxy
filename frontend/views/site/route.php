<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = '代理路由列表';
$model = new \frontend\models\ReourceMap();
$environments = $model->find()->all();
$list=[];
foreach ($environments as $environment) {
    $data = $environment->toArray();
    $modules = json_decode($data['data'], true);
    $list[$data['environment']] = [];
    foreach ($modules as $module) {
        $list[$data['environment']][$module['module']] = $module['ip'].':'.$module['port'];
    }
}
?>
<div class="site-route">
    <h1><?= Html::encode($this->title) ?></h1>
    <pre><?php echo print_r($list, true); ?></pre>
</div>
