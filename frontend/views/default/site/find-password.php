<?php

use yii\helpers\Url;
?>
<div class="container">
    <div class="find-password-form panel panel-default">
        <div class="panel-heading text-center">忘记密码</div>
        <div class="panel-body">
            <form class="form-ajax form-horizontal" action="<?= Url::to(['find-password']) ?>" method="post" autocomplete="off" onsubmit="return false;">
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">账号</label>
                    <div class="col-sm-4">
                        <input data-rule="账号:required" type="text" class="form-control" id="username" name="FindPasswordForm[username]" maxlength="20" placeholder="请输入手机号 / 邮箱 / 用户名">
                    </div>
                </div>
                <div class="form-group">
                    <label for="captcha" class="col-sm-2 control-label">验证码</label>
                    <div class="col-sm-2">
                        <input data-rule="验证码:required;length(4)" type="text" class="form-control" id="captcha" name="FindPasswordForm[captcha]" maxlength="4">
                    </div>
                    <div class="col-sm-2">
                        <img class="captcha-image" src="<?= Url::to(['captcha']); ?>" alt="看不清楚请点击换一个试试" title="看不清楚请点击换一个试试">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">下一步 验证身份</button>
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
    });
</script>