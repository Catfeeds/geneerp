<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '编辑个人资料';
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_mobile')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
