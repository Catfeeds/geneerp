<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use common\models\ContentModel;

if ($model->isNewRecord) {
    $model->c_status = 1;
    $model->c_sort = $model->c_pagesize = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_template_list')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_template_page')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_pagesize')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'field_list')->checkboxList(ContentModel::getKey(), ['value' => json_decode($model->c_config)]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>