<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '管理员登录';

$username = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$password = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">管理员登录</div>
    <div class="login-box-body">
        <p class="login-box-msg">请输入账号和密码</p>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username', $username)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
        <?= $form->field($model, 'password', $password)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'remember_me')->checkbox() ?>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <a href="mailto:19744244@qq.com">忘记密码</a><br>
    </div>
</div>