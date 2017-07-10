<?php

use yii\helpers\Url;
use yii\helpers\Html;

common\assets\DefaultAsset::register($this);
common\assets\CommonAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= $this->title ?> - <?= Yii::$app->params['site_title'] ?></title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
        <?php $this->head() ?>
        <!--[if lt IE 9]>
          <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?= $this->render('_header'); ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="list-group">
                        <a href="<?= Url::to(['user/index']) ?>" class="list-group-item active"><i class="glyphicon glyphicon-home" aria-hidden="true"></i> 欢迎页</a>
                        <a href="<?= Url::to(['profile/index']) ?>" class="list-group-item"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> 个人资料</a>
                        <a href="<?= Url::to(['profile/security']) ?>" class="list-group-item"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 账户安全</a>
                    </div>
                </div>
                <div class="col-sm-10">
                    <?= $content; ?>
                </div>
            </div>
        </div>
        <?= $this->render('_footer'); ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>