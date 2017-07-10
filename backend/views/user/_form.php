<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use common\models\User;
use common\models\UserGroup;

if ($model->isNewRecord) {
    $model->c_status = 1;
    $model->c_mobile_verify = $model->c_email_verify = User::VERIFY_NO;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_group_id')->dropDownList(UserGroup::getKeyValueCache(), ['prompt' => '选择用户组']) ?>
        <?= $form->field($model, 'c_user_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'confirm_password')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_mobile')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_mobile_verify')->radioList(User::getVerifyStatusText()) ?>
        <?= $form->field($model, 'c_email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_email_verify')->radioList(User::getVerifyStatusText()) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>