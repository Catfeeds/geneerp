<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;

$this->title = '编辑oauth授权';
$this->params['breadcrumbs'][] = ['label' => 'oauth授权列表', 'url' => ['index']];
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_api_key')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_api_secret')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>