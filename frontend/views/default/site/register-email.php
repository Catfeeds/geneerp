<?php

use yii\helpers\Url;
?>
<div class="container">
    <div class="register-form panel panel-default">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?= Url::to(['register-email']); ?>">邮箱注册</a></li>
            <li role="presentation"><a href="<?= Url::to(['register-mobile']); ?>">手机注册</a></li>
        </ul>
        <div class="panel-body">
            <form class="form-ajax form-horizontal" action="<?= Url::to(['register-email']) ?>" method="post" autocomplete="off" onsubmit="return false;">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-4">
                        <input data-rule="邮箱:required;email" type="text" class="form-control" id="email" name="RegisterEmailForm[email]" maxlength="50" placeholder="请输入邮箱">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-4">
                        <input data-rule="密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="password" name="RegisterEmailForm[password]" maxlength="20" placeholder="请输入密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="captcha" class="col-sm-2 control-label">验证码</label>
                    <div class="col-sm-2">
                        <input data-rule="验证码:required;length(4)" type="text" class="form-control" id="captcha" name="RegisterEmailForm[captcha]" maxlength="4">
                    </div>
                    <div class="col-sm-2">
                        <img class="captcha-image" src="<?= Url::to(['captcha']); ?>" alt="看不清楚请点击换一个试试" title="看不清楚请点击换一个试试">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email-captcha" class="col-sm-2 control-label">邮箱校验码</label>
                    <div class="col-sm-2">
                        <input data-rule="邮箱校验码:required;length(4)" type="text" class="form-control" id="email-captcha" name="RegisterEmailForm[email_captcha]" maxlength="4">
                    </div>
                    <div class="col-sm-2"><button type="button" class="btn btn-default" id="email-code-btn" data-url="<?= Url::to(['email-code']); ?>" data-form="RegisterEmailForm" data-type="code_register">获取邮箱校验码</button></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label><input type="checkbox" value="1">我已阅读并同意《用户注册协议》</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled="disabled">同意协议并注册</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.captcha-image').click(function () {
            $(this).attr('src', '<?= Url::to(['captcha', 'refresh' => time()]); ?>');
        });
        $('input[type=checkbox]').click(function () {
            if ($(this).is(':checked')) {
                $('#submit-btn').removeAttr('disabled');
            } else {
                $('#submit-btn').attr('disabled', true);
            }
        });
    });
</script>