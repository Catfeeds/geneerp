<?php

use yii\helpers\Url;
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="img/user2-160x160.jpg" class="img-circle" alt="我的头像">
            </div>
            <div class="pull-left info">
                <p><?= isset(Yii::$app->user->identity->c_admin_name) ? Yii::$app->user->identity->c_admin_name : '游客'; ?></p>
                <a href="<?= Url::to(['site/online']) ?>"><i class="glyphicon glyphicon-ok-circle text-success"></i> Online</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="请输入订单关键词"/>
                <span class="input-group-btn">
                    <button type="submit" name="订单搜索" class="btn btn-flat"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>
        <?= backend\widgets\Menu::widget() ?>
    </section>
</aside>