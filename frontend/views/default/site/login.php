<?php

use yii\helpers\Url;

$this->title = '用户登录';
?>
<div class="container">
    <div class="login-form panel panel-default">
        <div class="panel-heading text-center">用户登录</div>
        <div class="panel-body">
            <form class="form-ajax form-horizontal" action="<?= Url::to(['login']) ?>" method="post" autocomplete="off" onsubmit="return false;">
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">账号</label>
                    <div class="col-sm-4">
                        <input data-rule="账号:required" type="email" class="form-control" id="username" name="LoginForm[username]" maxlength="20" placeholder="请输入手机号 / 邮箱 / 用户名">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-4">
                        <input data-rule="密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="password" name="LoginForm[password]" maxlength="20" placeholder="请输入密码">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label><input type="checkbox" name="LoginForm[remember_me]" value="1"> 24小时内免登录</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">立即登录</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center col-sm-offset-2 col-sm-2"><a href="<?= Url::to(['register-mobile']); ?>">马上注册</a></div>
                    <div class="text-center col-sm-2"><a href="<?= Url::to(['site/find-password']) ?>">忘记密码</a></div>
                </div>
            </form>
        </div>
    </div>
</div>

