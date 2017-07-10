<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '修改登录密码';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <div class="form-group">
            <label class="control-label"><?= $model->c_admin_name ?></label>
        </div>
        <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'confirm_password')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
