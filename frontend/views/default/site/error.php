<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container">
    <div class="alert alert-danger" role="alert">
        <h4><?= $name ?></h4>
        <p><?= nl2br(Html::encode($message)) ?></p>
        <p>
            您可以 <a href="javascript:void(0);" onclick="history.back();">返回上一页</a>
            或者 <a href="<?= Url::to(['site/index']); ?>">返回首页</a>
        </p>
    </div>
</div>