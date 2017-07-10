<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\uploader\Picture;
use common\models\Link;

if ($model->isNewRecord) {
    $model->c_type = $model->c_status = 1;
    $model->c_sort = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_type')->radioList(Link::getType()) ?>
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_url')->textInput(['maxlength' => true]) ?>
        <div class="field-admanage-c_picture">
            <div class="form-group"><label>图片上传</label></div>
            <?= Picture::widget(['value' => $model->c_picture, 'object_id' => $model->c_id]); ?>
        </div>
        <?= $form->field($model, 'c_note')->textArea(['maxlength' => true, 'rows' => 3]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Link::getStatus()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
