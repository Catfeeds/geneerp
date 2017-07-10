<?php

use yii\helpers\Url;
?>
<div class="container">
    <div class="alert alert-success" role="alert">
        <h4>新密码设置成功</h4>
        <a class="btn btn-success" href="<?= Url::to(['site/login']); ?>" role="button">立即登录</a>
    </div>
</div>