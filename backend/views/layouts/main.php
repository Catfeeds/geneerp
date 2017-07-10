<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use common\assets\CommonAsset;

AppAsset::register($this);
AppAsset::overrideSystemConfirm();
CommonAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">
            <?= $this->render('header.php') ?>
            <?= $this->render('left.php') ?>
            <?= $this->render('content.php', ['content' => $content]) ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
