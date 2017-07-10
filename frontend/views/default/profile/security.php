<?php

use yii\helpers\Url;
use common\extensions\Util;
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 账户安全</div>
    <div class="panel-body ucenter-bg">
        <div class="row">
            <div class="col-sm-6">
                <div class="info-box mb15">
                    <span class="info-box-icon bg-light-blue"><i class="glyphicon glyphicon-dashboard" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">注册日期：<?= date('Y-m-d', Yii::$app->user->identity->c_reg_date) ?></span>
                        <span class="info-box-text">最后登录：<?= date('Y-m-d H:i:s', Yii::$app->user->identity->c_last_login_time) ?> &nbsp;&nbsp;&nbsp;&nbsp;IP:<?= long2ip(Yii::$app->user->identity->c_last_ip) ?></span>
                        <span class="info-box-text"><a href="<?= Url::to(['change-password']); ?>"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> 更改密码</a></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="info-box mb15">
                    <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-phone" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">
                            手机账号：<?= Util::hiddenMobile(Yii::$app->user->identity->c_mobile) ?>
                        </span>
                        <span class="info-box-text">认证状态：
                            <?php if (Yii::$app->user->identity->c_mobile && Yii::$app->user->identity->c_mobile_verify == 1) { ?>
                                <span class="label label-success">已认证</span>
                            <?php } else { ?>
                                <span class="label label-danger">未认证</span>
                            <?php } ?>
                        </span>
                        <span class="info-box-text"><a href="<?= Url::to(['change-mobile']); ?>"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> 更改手机号</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">
                            邮箱账号：<?= Util::hiddenEmail(Yii::$app->user->identity->c_email) ?>
                        </span>
                        <span class="info-box-text">认证状态：
                            <?php if (Yii::$app->user->identity->c_email && Yii::$app->user->identity->c_email_verify == 1) { ?>
                                <span class="label label-success">已认证</span>
                            <?php } else { ?>
                                <span class="label label-danger">未认证</span>
                            <?php } ?>
                        </span>
                        <span class="info-box-text"><a href="<?= Url::to(['change-email']); ?>"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> 更改邮箱</a></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">支付密码：
                            <?php if (Yii::$app->user->identity->c_pay_password) { ?>
                                <span class="label label-success">已开启</span>
                            <?php } else { ?>
                                <span class="label label-danger">未开启</span>
                            <?php } ?>
                        </span>
                        <?php if (Yii::$app->user->identity->c_pay_password) { ?>
                            <span class="info-box-text"><a href="<?= Url::to(['change-pay-password']); ?>"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> 更改支付密码</a></span>
                        <?php } ?>
                        <span class="info-box-text">
                            <?php if (Yii::$app->user->identity->c_pay_password) { ?>
                                <a href="<?= Url::to(['close-pay-password']); ?>"><i class="glyphicon glyphicon-off" aria-hidden="true"></i> 关闭支付密码</a>
                            <?php } else { ?>
                                <a href="<?= Url::to(['change-pay-password']); ?>"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> 开启支付密码</a>
                            <?php } ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>