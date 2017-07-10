<?php

use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 设置支付密码</div>
    <div class="panel-body">
        <form class="form-ajax form-horizontal" action="<?= Url::to(['change-pay-password']) ?>" method="post" autocomplete="off" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?= Yii::$app->user->identity->c_user_name ?></p>
                </div>
            </div>
            <?php if (Yii::$app->user->identity->c_pay_password) { ?>
                <div class="form-group">
                    <label for="old_pay_password" class="col-sm-2 control-label">原支付密码</label>
                    <div class="col-sm-4">
                        <input data-rule="原登录密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="old_pay_password" name="User[old_pay_password]" maxlength="20">
                    </div>
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label for="old_password" class="col-sm-2 control-label">登录密码</label>
                    <div class="col-sm-4">
                        <input data-rule="登录密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="old_password" name="User[old_password]" maxlength="20">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="new_pay_password" class="col-sm-2 control-label">新支付密码</label>
                <div class="col-sm-4">
                    <input data-rule="新支付密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="new_pay_password" name="User[new_pay_password]" maxlength="20">
                </div>
            </div>
            <div class="form-group">
                <label for="repassword" class="col-sm-2 control-label">确认新支付密码</label>
                <div class="col-sm-4">
                    <input data-rule="确认新支付密码:required;match(User[new_pay_password])" type="password" class="form-control" id="repassword" maxlength="20">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">设置支付密码</button>
                </div>
            </div>
        </form>
    </div>
</div>