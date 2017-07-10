<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\uploader\Picture;
use common\widgets\uploader\File;
use common\widgets\editor\Editor;
use common\models\Content;
use common\models\ContentCategory;
use common\models\ContentSpecial;
use common\models\ContentLabel;
use common\models\ContentModel;

if ($model->isNewRecord) {
    $model->c_status = $model->c_source = 1;
    $model->c_sort = 0;
}
?>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">基本信息</a></li>
    <li><a href="#tab2" data-toggle="tab">图片附件</a></li>
    <li><a href="#tab3" data-toggle="tab">编辑内容</a></li>
    <li><a href="#tab4" data-toggle="tab">优化设置</a></li>
</ul>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'editer_form']]); ?>
    <div class="box-body tab-content">
        <div class="tab-pane active" id="tab1">
            <?= $form->field($model, 'c_category_id')->dropDownList(ContentCategory::formatDropDownList(), ['prompt' => '选择类别']) ?>
            <?= $form->field($model, 'c_special_id')->dropDownList(ContentSpecial::formatDropDownList(), ['prompt' => '选择专题']) ?>
            <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_source')->radioList(Content::getSource()) ?>
            <div class="row">  
                <?= $form->field($model, 'c_author', ['options' => ['class' => 'form-group col-xs-4']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_source_site', ['options' => ['class' => 'form-group col-xs-4']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_source_url', ['options' => ['class' => 'form-group col-xs-4']])->textInput(['maxlength' => true]) ?>  
            </div>
            <?= $form->field($model, 'label')->checkboxList(Content::getLabel(), ['value' => ContentLabel::getColumn('c_type', ['c_content_id' => $model->c_id])]) ?>
            <?= $form->field($model, 'c_status')->radioList(Content::getStatus()) ?>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="field-content-c_picture">
                <div class="form-group"><label>图片上传</label></div>
                <?= Picture::widget(['value' => $model->c_picture, 'object_id' => $model->c_id]); ?>
            </div>
            <div class="field-content-c_file">
                <div class="form-group"><label>附件上传</label></div>
                <?= File::widget(['value' => $model->c_file, 'object_id' => $model->c_id]); ?>
            </div>
        </div>
        <div class="tab-pane" id="tab3">
            <div class="field-content-c_pc_content">
                <div class="form-group"><label>PC内容</label></div>
                <?= Editor::widget(['value' => isset($model->contentText) ? $model->contentText->c_pc_content : '', 'object_id' => $model->c_id, 'name' => 'pc_content']); ?>
            </div>
            <div class="field-content-c_h5_content">
                <div class="form-group"><label>H5内容</label></div>
                <?= Editor::widget(['value' => isset($model->contentText) ? $model->contentText->c_h5_content : '', 'object_id' => $model->c_id, 'name' => 'h5_content']); ?>
            </div>
            <div class="field-content-c_app_content">
                <div class="form-group"><label>APP内容</label></div>
                <?= Editor::widget(['value' => isset($model->contentText) ? $model->contentText->c_app_content : '', 'object_id' => $model->c_id, 'name' => 'app_content']); ?>
            </div>
        </div>
        <div class="tab-pane" id="tab4">
            <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_short')->textInput(['maxlength' => true]) ?>
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
<?php
$model_json = ContentModel::getContentModelJson();
$field_array = json_encode(array_keys(ContentModel::getKey()));
$js = <<<EOT
    var field_array = $field_array;
    var model_json = $model_json;
    function setFieldShowHide(model_id){
        $.each(field_array,function(index,value){
             $('.field-content-'+value).hide();
        });
        if(model_json.hasOwnProperty(model_id)){
            var array = model_json[model_id];
            if(array){
                $.each(array,function(index,value){
                     $('.field-content-'+value).show();
                });
            }
        }
    }
    function setSourceShowHide(source){
        if(source==1){
            $('.field-content-c_source_site').hide(); 
            $('.field-content-c_source_url').hide();     
        }else{
            $('.field-content-c_source_site').show(); 
            $('.field-content-c_source_url').show();   
        }
    }
    $(function () {
        setFieldShowHide($model->c_category_id);
        setSourceShowHide($model->c_source);
        $('#content-c_category_id').change(function () {
            setFieldShowHide($(this).val());
        });
        $('#content-c_source input').click(function () {
            setSourceShowHide($(this).val());
        });
    });
EOT;
backend\assets\AppAsset::addScript($js);

