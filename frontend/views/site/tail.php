<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

\frontend\assets\TailAsset::register($this);

$this->title = 'tail -f swoole.log';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-tail">
    <div class="shell-wrap">
        <p class="shell-top-bar"><?php echo $this->title;?></p>
        <div class="shell-body" id="tail">
            <pre class="line"><?php echo $this->title;?></pre>
        </div>
    </div>
</div>

