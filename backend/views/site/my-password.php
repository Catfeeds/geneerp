<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '修改登录密码';
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>