<?php

use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 设置邮箱</div>
    <div class="panel-body">
        <form class="form-ajax form-horizontal" action="<?= Url::to(['change-email']) ?>" method="post" autocomplete="off" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?= Yii::$app->user->identity->c_user_name ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="old_password" class="col-sm-2 control-label">登录密码</label>
                <div class="col-sm-4">
                    <input data-rule="登录密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="old_password" name="User[old_password]" maxlength="20">
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