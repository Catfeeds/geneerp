<?php

use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 设置登录密码</div>
    <div class="panel-body">
        <form class="form-ajax form-horizontal" action="<?= Url::to(['change-password']) ?>" method="post" autocomplete="off" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?= Yii::$app->user->identity->c_user_name ?></p>
                </div>
            </div>
            <?php if (Yii::$app->user->identity->c_login_password) { ?>
                <div class="form-group">
                    <label for="old_password" class="col-sm-2 control-label">原登录密码</label>
                    <div class="col-sm-4">
                        <input data-rule="原登录密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="old_password" name="User[old_password]" maxlength="20">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="new_password" class="col-sm-2 control-label">新登录密码</label>
                <div class="col-sm-4">
                    <input data-rule="新登录密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="new_password" name="User[new_password]" maxlength="20">
                </div>
            </div>
            <div class="form-group">
                <label for="repassword" class="col-sm-2 control-label">确认新登录密码</label>
                <div class="col-sm-4">
                    <input data-rule="确认新登录密码:required;match(User[new_password])" type="password" class="form-control" id="repassword" maxlength="20">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">设置登录密码</button>
                </div>
            </div>
        </form>
    </div>
</div>