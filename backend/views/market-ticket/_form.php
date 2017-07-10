<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use common\models\MarketTicket;

if ($model->isNewRecord) {
    $model->c_status = 1;
    $model->c_point = 0;
    $model->c_count = 0;
    $model->c_exp = 0;
    $model->c_goods_ids = 0;
} else {
    $model->c_start_time = date('Y-m-d', $model->c_start_time);
    $model->c_end_time = date('Y-m-d', $model->c_end_time);
}
//长度数组
$length_array = [];
for ($i = 4; $i < 13; $i++) {
    $length_array[$i] = $i . '位';
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title', ['options' => ['class' => 'form-group col-xs-6']])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_value', ['options' => ['class' => 'form-group col-xs-6']])->textInput(['maxlength' => true, 'disabled' => $model->c_count == 0 ? false : 'disabled']) ?>
    </div>  
    <div class="box-body">
        <?= $form->field($model, 'c_start_time', ['options' => ['class' => 'form-group col-xs-6']])->textInput(['maxlength' => true, 'class' => 'form-control form-date']) ?>
        <?= $form->field($model, 'c_end_time', ['options' => ['class' => 'form-group col-xs-6']])->textInput(['maxlength' => true, 'class' => 'form-control form-date']) ?>   
    </div>  
    <div class="box-body">
        <?= $form->field($model, 'c_point', ['options' => ['class' => 'form-group col-xs-4']])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_exp', ['options' => ['class' => 'form-group col-xs-4']])->textInput(['maxlength' => true]) ?>   
        <?= $form->field($model, 'c_goods_ids', ['options' => ['class' => 'form-group col-xs-4']])->textInput(['maxlength' => true])->label('限定商品ID(多个英文逗号隔开)') ?>   
    </div>
    <div class="box-body">
        <?= $form->field($model, 'c_number_length', ['options' => ['class' => 'form-group col-xs-6']])->dropDownList($length_array, ['prompt' => '请选择', 'disabled' => $model->c_count == 0 ? false : 'disabled']) ?>
        <?= $form->field($model, 'c_number_type', ['options' => ['class' => 'form-group col-xs-6']])->dropDownList(MarketTicket::getType(), ['prompt' => '请选择', 'disabled' => $model->c_count == 0 ? false : 'disabled']) ?>
    </div> 
    <div class="box-body">
        <?= $form->field($model, 'c_password_length', ['options' => ['class' => 'form-group col-xs-6']])->dropDownList($length_array, ['prompt' => '请选择', 'disabled' => $model->c_count == 0 ? false : 'disabled']) ?>
        <?= $form->field($model, 'c_password_type', ['options' => ['class' => 'form-group col-xs-6']])->dropDownList(MarketTicket::getType(), ['prompt' => '请选择', 'disabled' => $model->c_count == 0 ? false : 'disabled']) ?>
        <?= $form->field($model, 'c_status', ['options' => ['class' => 'form-group col-xs-12']])->radioList(Util::getStatusText()) ?>
    </div> 

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
