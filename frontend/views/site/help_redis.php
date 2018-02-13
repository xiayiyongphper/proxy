<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '帮助(redis)';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <h2>使用方法</h2>
    <ul>
        <li>电脑添加host</li>
        <ul>
            <li>172.16.10.203 proxy.laile.com</li>
        </ul>
        <li>添加Debug用户</li>
        <ul>
            <li>在<?= Html::a('设备列表(redis)', ['device/index_redis']) ?>中添加需要测试的customer_id</li>
        </ul>
        <li>查看数据</li>
        <ul>
            <li>直接在<?= Html::a('访问记录(redis)', ['log/index_redis']) ?>页面,选择你的用户id查看数据</li>
        </ul>
    </ul>

    <h2>原理图</h2>

    <h3>无代理时</h3>
    <iframe id="embed_dom" name="embed_dom" frameborder="0" style="border:1px solid #000;display:block;width:800px; height:550px;" src="https://www.processon.com/embed/575e8982e4b06efde2b81143"></iframe>

    <h3>有代理后</h3>
    <iframe id="embed_dom" name="embed_dom" frameborder="0" style="border:1px solid #000;display:block;width:1000px; height:800px;" src="https://www.processon.com/embed/587cbaa1e4b049e795879f99"></iframe>

</div>
