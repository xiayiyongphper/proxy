<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '帮助';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <h2>使用方法</h2>
    <ul>
        <li>电脑添加host</li>
        <ul>
            <li>172.16.10.239 proxy.laile.com</li>
        </ul>
        <li><del>手机配置host</del>(现已不需要这一步,直接加入无线网Lelai即可)</li>
        <ul>
            <li><del>172.16.10.239 route.lelai.com</del></li>
            <li><del>root的安卓机：安装"网络军刀"直接配host</del></li>
            <li><del>未root的安卓或者IOS：将DNS设置为172.16.10.222。</del></li>
            <li><del>172.16.10.222有DNS服务器，会把route.lelai.com指向swoole_proxy所在机器172.16.10.239，达到配HOST的效果。</del></li>
        </ul>
        <li>添加设备deviceId到数据库，此步骤只需要做一次，如做过请直接略过</li>
        <ul>
            <li>到<?= Html::a('未知设备列表', ['unknow/index']) ?>页面点击"清空列表"按钮。</li>
            <li>确保1.手机安装的app包请求route.fetch接口使用的是route.lelai.com域名,2.已经做好"手机配置host"步骤。清除app所有缓存,打开app会触发请求记录。</li>
            <li>刷新<?= Html::a('未知设备列表', ['unknow/index']) ?>页面,查看Device Id列中你的deviceId</li>
            <li>在<?= Html::a('设备列表', ['device/index']) ?>页面中点击"添加设备"按钮:</li>
            <ul>
                <li>title:设备备注(如"颜巧-锤子-测试")</li>
                <li>deviceId:填写上一步拿到的deviceId</li>
                <li>charles:你的电脑ip和代理端口(如"172.16.10.250:8888")。也可以直接在<?= Html::a('访问记录', ['log/index']) ?>页面查看。</li>
                <li>environment:你需要测试的环境,此字段只可选择<?= Html::a('环境列表', ['site/environment']) ?>里的environment值(如"product")</li>
            </ul>
            <li>点击"新建"保存你的设备</li>
        </ul>
        <li>电脑打开charles或fiddler4代理软件</li>
        <li>清除app缓存,登出账号,重启app,观察charles里的数据</li>
        <li>也可以直接在<?= Html::a('访问记录', ['log/index']) ?>页面,选择你的设备查看数据</li>
    </ul>
    
    <!--
    <h2>使用方法</h2>
    <ul>
        <li>电脑添加host</li>
        <ul>
            <li>172.16.10.239 proxy.laile.com</li>
        </ul>
        <li>手机配置host</li>
        <ul>
            <li>172.16.10.239 route.lelai.com</li>
            <li>root的安卓机：安装"网络军刀"直接配host</li>
            <li>未root的安卓或者IOS：将DNS设置为172.16.10.222。</li>
            <li>172.16.10.222有DNS服务器，会把route.lelai.com指向swoole_proxy所在机器172.16.10.239，达到配HOST的效果。</li>
        </ul>
        <li>添加设备deviceId到数据库，此步骤只需要做一次，如做过请直接略过</li>
        <ul>
            <li>到<?= Html::a('未知设备列表', ['unknow/index']) ?>页面点击"清空列表"按钮。</li>
            <li>确保1.手机安装的app包请求route.fetch接口使用的是route.lelai.com域名,2.已经做好"手机配置host"步骤。清除app所有缓存,打开app会触发请求记录。</li>
            <li>刷新<?= Html::a('未知设备列表', ['unknow/index']) ?>页面,查看Device Id列中你的deviceId</li>
            <li>在<?= Html::a('设备列表', ['device/index']) ?>页面中点击"添加设备"按钮:</li>
            <ul>
                <li>title:设备备注(如"颜巧-锤子-测试")</li>
                <li>deviceId:填写上一步拿到的deviceId</li>
                <li>charles:你的电脑ip和代理端口(如"172.16.10.250:8888")。也可以直接在<?= Html::a('访问记录', ['log/index']) ?>页面查看。</li>
                <li>environment:你需要测试的环境,此字段只可选择<?= Html::a('环境列表', ['site/environment']) ?>里的environment值(如"product")</li>
            </ul>
            <li>点击"新建"保存你的设备</li>
        </ul>
        <li>电脑打开charles或fiddler4代理软件</li>
        <li>清除app缓存,登出账号,重启app,观察charles里的数据</li>
        <li>也可以直接在<?= Html::a('访问记录', ['log/index']) ?>页面,选择你的设备查看数据</li>
    </ul>
    -->


    <h2>原理图</h2>

    <h3>无代理时</h3>
    <iframe id="embed_dom" name="embed_dom" frameborder="0" style="border:1px solid #000;display:block;width:800px; height:550px;" src="https://www.processon.com/embed/575e8982e4b06efde2b81143"></iframe>

    <h3>有代理后</h3>
    <iframe id="embed_dom" name="embed_dom" frameborder="0" style="border:1px solid #000;display:block;width:1400px; height:1100px;" src="https://www.processon.com/embed/575e92a3e4b06f2d5ab8bc45"></iframe>

</div>
