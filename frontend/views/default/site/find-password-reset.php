<?php

use yii\helpers\Url;
?>
<div class="container">
    <div class="find-password-form panel panel-default">
        <div class="panel-heading text-center">忘记密码</div>
        <div class="panel-body">
            <form class="form-ajax form-horizontal" action="<?= Url::to(['find-password-reset']) ?>" method="post" autocomplete="off" onsubmit="return false;">
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-4">
                        <input data-rule="密码:required;onlyLetterNumber;length(6~20)" type="password" class="form-control" id="password" name="FindPasswordResetForm[password]" maxlength="20" placeholder="请输入密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="repassword" class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-4">
                        <input data-rule="确认密码:required;match(FindPasswordResetForm[password])" type="password" class="form-control" id="repassword" maxlength="20" placeholder="请输入确认密码">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">下一步</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>