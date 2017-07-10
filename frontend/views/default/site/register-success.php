<?php

use yii\helpers\Url;
?>
<div class="container">
    <div class="alert alert-success" role="alert">
        <h4>恭喜注册成功</h4>
        <a class="btn btn-success" href="<?= Url::to(['user/index']); ?>" role="button">进入用户中心</a>
    </div>
</div>