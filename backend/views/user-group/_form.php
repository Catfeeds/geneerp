<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($model->isNewRecord) {
    $model->c_sort = $model->c_discount = $model->c_minexp = $model->c_maxexp = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_icon')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_discount')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_minexp')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_maxexp')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>