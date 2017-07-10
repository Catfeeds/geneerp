<?php

use yii\helpers\Url;
use common\models\UserProfile;
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-home" aria-hidden="true"></i> 欢迎页</div>
    <div class="panel-body ucenter-bg">
        <?php if (empty(Yii::$app->user->identity->c_login_password)) { ?>
            <div class="alert alert-danger" role="alert">
                您尚未设置登录密码，赶快去 <a href="<?= Url::to(['profile/setting-password']); ?>">设置登录密码</a> 吧！
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="info-box">
                    <?php if (Yii::$app->user->identity->userProfile->c_head) { ?>
                        <span class="info-box-img"><img src="<?= UserProfile::getHead() ?>"></span>
                    <?php } else { ?>
                        <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                    <?php } ?>
                    <div class="info-box-content">
                        <span class="info-box-text">用户账号：<?= Yii::$app->user->identity->c_user_name ?></span>
                        <span class="info-box-text">用户等级：<?= Yii::$app->user->identity->userGroup->c_title ?></span>
                        <span class="info-box-text">经验总值：<?= Yii::$app->user->identity->userAcount->c_exp ?> 
                            <span class="pull-right"><a href="<?= Url::to(['user/empirical']); ?>"><i class="glyphicon glyphicon-eye-open"></i></a></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>