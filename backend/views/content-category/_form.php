<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\uploader\Picture;
use common\extensions\Util;
use common\models\ContentCategory;
use common\models\ContentModel;
use common\widgets\editor\Editor;

$dropdown = ContentCategory::formatDropDownList();
$dropdown[0] = '顶级菜单';
if ($model->isNewRecord) {
    $model->c_status = $model->c_home_block = 1;
    $model->c_sort = 0;
    $model->c_parent_id = (int) Yii::$app->request->get('parent_id', 0);
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
            <?= $form->field($model, 'c_parent_id')->dropDownList($dropdown) ?>
            <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_model_id')->radioList(ContentModel::getKeyValueCache()) ?>
            <?= $form->field($model, 'c_url')->textInput(['maxlength' => true]) ?>
            <div class="field-contentcategory-c_content">
                <?= Editor::widget(['value' => isset($model->contentCategoryText) ? $model->contentCategoryText->c_content : '']); ?>
            </div>
            <?= $form->field($model, 'c_home_block')->radioList(Util::getStatusText()) ?>
            <?= $form->field($model, 'c_status')->radioList(ContentCategory::getStatus()) ?>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="field-contentcategory-c_picture">
                <div class="form-group"><label>图片上传</label></div>
                <?= Picture::widget(['value' => $model->c_picture, 'object_id' => $model->c_id]); ?>
            </div>
        </div>
        <div class="tab-pane" id="tab3">
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
$js = <<<EOT
    $(function () {
        function setShowHide(type) {
            var url = $('.field-contentcategory-c_url');
            var content = $('.field-contentcategory-c_content');
            if (type === '1') {
                url.show();
                content.hide();
            } else if (type === '2') {
                url.hide();
                content.show();
            } else{
                url.hide();
                content.hide();
            }
        }
        setShowHide('$model->c_model_id');
        $('#contentcategory-c_model_id input').on('click', function () {
            setShowHide($(this).val());
        });
    });
EOT;
backend\assets\AppAsset::addScript($js);
