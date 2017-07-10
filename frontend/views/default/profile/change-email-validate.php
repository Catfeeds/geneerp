<?php

use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 设置邮箱</div>
    <div class="panel-body">
        <form class="form-ajax form-horizontal" action="<?= Url::to(['change-email-validate']) ?>" method="post" autocomplete="off" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?= Yii::$app->user->identity->c_user_name ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">新邮箱</label>
                <div class="col-sm-4">
                    <input data-rule="新邮箱:required;email" type="text" class="form-control" id="email" name="ChangEmailValidateForm[email]" maxlength="50" placeholder="请输入邮箱">
                </div>
            </div>
            <div class="form-group">
                <label for="captcha" class="col-sm-2 control-label">验证码</label>
                <div class="col-sm-2">
                    <input data-rule="验证码:required;length(4)" type="text" class="form-control" id="captcha" name="ChangEmailValidateForm[captcha]" maxlength="4">
                </div>
                <div class="col-sm-2">
                    <img class="captcha-image" src="<?= Url::to(['captcha']); ?>" alt="看不清楚请点击换一个试试" title="看不清楚请点击换一个试试">
                </div>
            </div>
            <div class="form-group">
                <label for="email-captcha" class="col-sm-2 control-label">邮箱校验码</label>
                <div class="col-sm-2">
                    <input data-rule="邮箱校验码:required;length(4)" type="text" class="form-control" id="email-captcha" name="ChangEmailValidateForm[email_captcha]" maxlength="4">
                </div>
                <div class="col-sm-2"><button type="button" class="btn btn-default" id="email-code-btn" data-url="<?= Url::to(['site/email-code']); ?>" data-form="ChangEmailValidateForm" data-type="code_change_email">获取邮箱校验码</button></div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">下一步</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function () {
        $('.captcha-image').click(function () {
            $(this).attr('src', '<?= Url::to(['captcha', 'refresh' => time()]); ?>');
        });
    });
</script>