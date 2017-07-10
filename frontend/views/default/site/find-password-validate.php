<?php

use yii\helpers\Url;
use common\extensions\Util;
?>
<div class="container">
    <div class="find-password-form panel panel-default">
        <div class="panel-heading text-center">忘记密码</div>
        <div class="panel-body">
            <form class="form-ajax form-horizontal" action="<?= Url::to(['find-password-validate']) ?>" method="post" autocomplete="off" onsubmit="return false;">
                <div class="form-group">
                    <label for="select_type" class="col-sm-2 control-label">验证方式</label>
                    <div class="col-sm-4">
                        <select id="select_type" class="form-control">
                            <?php if ($model->c_mobile_verify == 1) { ?>
                                <option value="mobile" data-url="<?= Url::to(['find-password-validate', 'type' => 'mobile']) ?>"<?= (empty($type) || $type === 'mobile') ? ' selected' : '' ?>>已认证手机</option>
                            <?php } ?>
                            <?php if ($model->c_email_verify == 1) { ?>
                                <option value="email" data-url="<?= Url::to(['find-password-validate', 'type' => 'email']) ?>"<?= ($model->c_mobile_verify == 2 || $type === 'email') ? ' selected' : '' ?>>已认证邮箱</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php if ((empty($type) || $type === 'mobile') && $model->c_mobile_verify == 1) { ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">已验证手机</label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><?= Util::hiddenMobile($model->c_mobile) ?></p>
                            <input type="hidden" id="mobile" name="FindPasswordValidateForm[username]" value="<?= $model->c_mobile ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="captcha" class="col-sm-2 control-label">验证码</label>
                        <div class="col-sm-2">
                            <input data-rule="验证码:required;length(4)" type="text" class="form-control" id="captcha" name="FindPasswordValidateForm[captcha]" maxlength="4">
                        </div>
                        <div class="col-sm-2">
                            <img class="captcha-image" src="<?= Url::to(['captcha']); ?>" alt="看不清楚请点击换一个试试" title="看不清楚请点击换一个试试">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sms-captcha" class="col-sm-2 control-label">短信验证码</label>
                        <div class="col-sm-2">
                            <input data-rule="短信验证码:required;length(4)" type="text" class="form-control" id="sms-captcha" name="FindPasswordValidateForm[sms_captcha]" maxlength="4">
                        </div>
                        <div class="col-sm-2"><button type="button" class="btn btn-default" id="sms-code-btn" data-url="<?= Url::to(['sms-code']); ?>" data-form="FindPasswordValidateForm" data-type="code_find_password">获取短信验证码</button></div>
                    </div>
                <?php } ?>
                <?php if (($model->c_mobile_verify != 1 || $type === 'email') && $model->c_email_verify == 1) { ?>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">已验证邮箱</label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><?= Util::hiddenEmail($model->c_email) ?></p>
                            <input type="hidden" id="email" name="FindPasswordValidateForm[username]" value="<?= $model->c_mobile ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="captcha" class="col-sm-2 control-label">验证码</label>
                        <div class="col-sm-2">
                            <input data-rule="验证码:required;length(4)" type="text" class="form-control" id="captcha" name="FindPasswordValidateForm[captcha]" maxlength="4">
                        </div>
                        <div class="col-sm-2">
                            <img class="captcha-image" src="<?= Url::to(['captcha']); ?>" alt="看不清楚请点击换一个试试" title="看不清楚请点击换一个试试">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email-captcha" class="col-sm-2 control-label">邮箱校验码</label>
                        <div class="col-sm-2">
                            <input data-rule="邮箱校验码:required;length(4)" type="text" class="form-control" id="email-captcha" name="FindPasswordValidateForm[email_captcha]" maxlength="4">
                        </div>
                        <div class="col-sm-2"><button type="button" class="btn btn-default" id="email-code-btn" data-url="<?= Url::to(['email-code']); ?>" data-form="RegisterEmailForm" data-type="code_find_password">获取邮箱校验码</button></div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">下一步 设置新密码</button>
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
        $('#select_type').change(function () {
            window.location.href = $(this).children('option:selected').attr('data-url');
        });
    });
</script>