<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<header class="main-header">
    <?= Html::a('<span class="logo-mini">ERP</span><span class="logo-lg">ERP管理中心</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <?= backend\widgets\HeaderMenu::widget() ?>
                </ul>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <?= isset(Yii::$app->user->identity->c_admin_name) ? Yii::$app->user->identity->c_admin_name : '游客'; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= Url::to(['site/my-profile']) ?>" data-method="post"><i class="glyphicon glyphicon-user"></i> 个人资料</a></li>
                                <li><a href="<?= Url::to(['site/my-password']) ?>" data-method="post"><i class="glyphicon glyphicon-lock"></i> 修改密码</a></li>
                                <li><a href="<?= Url::to(['site/clear-cache']); ?>"><i class="glyphicon glyphicon-trash"></i> 清空缓存</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= Url::to(['site/logout']) ?>" data-method="post"><i class="glyphicon glyphicon-off"></i> 安全退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

