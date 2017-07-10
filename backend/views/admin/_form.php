<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use backend\models\AdminRole;

if ($model->isNewRecord) {
    $model->c_status = 1;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?php
        if ($model->isNewRecord) {
            ?>
            <?= $form->field($model, 'c_admin_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
        <?php } else { ?>
            <div class="form-group">
                <label class="control-label"><?= $model->c_admin_name ?></label>
            </div>
        <?php } ?>
        <?= $form->field($model, 'c_mobile')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
        <?= $form->field($model, 'c_role_id')->radioList(AdminRole::getKeyValue()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
