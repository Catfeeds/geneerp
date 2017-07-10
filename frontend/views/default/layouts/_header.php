<?php

use yii\helpers\Url;
?>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Url::to(['site/index']) ?>">首页</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?= Url::to(['site/login']) ?>">登录</a></li>
                <li><a href="<?= Url::to(['site/register-mobile']) ?>">手机注册</a></li>
                <li><a href="<?= Url::to(['site/register-email']) ?>">邮箱注册</a></li>
                <li><a href="<?= Url::to(['site/find-password']) ?>">忘记密码</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">下拉菜单 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Url::to(['site/login']) ?>">登录</a></li>
                        <li><a href="<?= Url::to(['site/register-mobile']) ?>">手机注册</a></li>
                        <li><a href="<?= Url::to(['site/register-email']) ?>">邮箱注册</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= Url::to(['site/find-password']) ?>">忘记密码</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <?php if (!Yii::$app->user->isGuest) { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= Yii::$app->user->identity->c_user_name ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= Url::to(['user/index']) ?>">用户中心</a></li>
                            <li><a href="<?= Url::to(['user/profile']) ?>">个人资料</a></li>
                            <li><a href="<?= Url::to(['user/password']) ?>">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">我的文章</a></li>
                            <li><a href="#">发布文章</a></li>
                        </ul>
                    </li>
                    <li><a href="<?= Url::to(['user/logout']) ?>">退出</a></li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>