<?php

use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 设置手机号</div>
    <div class="panel-body">
        <form class="form-ajax form-horizontal" action="<?= Url::to(['change-mobile-validate']) ?>" method="post" autocomplete="off" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?= Yii::$app->user->identity->c_user_name ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">新手机号</label>
                <div class="col-sm-4">
                    <input data-rule="新手机号:required;mobile" type="text" class="form-control" name="ChangMobileValidateForm[mobile]" maxlength="11" placeholder="请输入手机号">
                </div>
            </div>
            <div class="form-group">
                <label for="captcha" class="col-sm-2 control-label">验证码</label>
                <div class="col-sm-2">
                    <input data-rule="验证码:required;length(4)" type="text" class="form-control" id="captcha" name="ChangMobileValidateForm[captcha]" maxlength="4">
                </div>
                <div class="col-sm-2">
                    <img class="captcha-image" src="<?= Url::to(['captcha']); ?>" alt="看不清楚请点击换一个试试" title="看不清楚请点击换一个试试">
                </div>
            </div>
            <div class="form-group">
                <label for="sms-captcha" class="col-sm-2 control-label">短信验证码</label>
                <div class="col-sm-2">
                    <input data-rule="短信验证码:required;length(4)" type="text" class="form-control" id="sms-captcha" name="ChangMobileValidateForm[sms_captcha]" maxlength="4">
                </div>
                <div class="col-sm-2"><button type="button" class="btn btn-default" id="sms-code-btn" data-url="<?= Url::to(['site/sms-code']); ?>" data-form="ChangMobileValidateForm" data-type="code_change_mobile">获取短信验证码</button></div>
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