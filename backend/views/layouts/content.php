<?php

use yii\widgets\Breadcrumbs;
use backend\widgets\Alert;

$home = ['label' => '<i class="glyphicon glyphicon-home"></i> 首页', 'url' => Yii::$app->homeUrl, 'encode' => false];
$links = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
$links[] = $this->title;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $this->title ?></h1>
        <?= Breadcrumbs::widget(['homeLink' => $home, 'links' => $links]) ?>
    </section>
    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2016-<?= date('Y') ?> <a href="http://www.jjcms.com">JJCMS.COM</a>.</strong> All rights reserved.
</footer>
<div class="control-sidebar-bg"></div>