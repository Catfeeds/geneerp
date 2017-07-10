<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\uploader\Picture;
use common\models\GoodsBrandCategory;

if ($model->isNewRecord) {
    $model->c_sort = 0;
}
?>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">基本信息</a></li>
    <li><a href="#tab2" data-toggle="tab">图片上传</a></li>
    <li><a href="#tab3" data-toggle="tab">优化设置</a></li>
</ul>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'editer_form']]); ?>
    <div class="box-body tab-content">
        <div class="tab-pane active" id="tab1">
            <?= $form->field($model, 'c_category_ids')->checkboxList(GoodsBrandCategory::getKeyValueSort(), ['value' => explode(',', $model->c_category_ids)]) ?>
            <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_url')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="field-contentcategory-c_picture">
                <div class="form-group"><label>图片上传</label></div>
                <?= Picture::widget(['value' => $model->c_picture, 'object_id' => $model->c_id]); ?>
            </div>
        </div>
        <div class="tab-pane" id="tab3">
            <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_seo')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_keyword')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_description')->textArea(['maxlength' => true, 'rows' => 3]) ?>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>