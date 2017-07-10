<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\uploader\Picture;
use common\widgets\uploader\File;
use common\extensions\Util;
use common\models\AdManage;
use common\models\AdPosition;

if ($model->isNewRecord) {
    $model->c_type = $model->c_status = 1;
    $model->c_sort = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_position_id')->dropDownList(AdPosition::getKeyValueCache(), ['prompt' => '选择广告位']) ?>
        <?= $form->field($model, 'c_type')->radioList(AdManage::getType()) ?>
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_url')->textInput(['maxlength' => true]) ?>
        <div class="field-admanage-c_picture">
            <div class="form-group"><label>图片上传</label></div>
            <?= Picture::widget(['value' => $model->c_content, 'object_id' => $model->c_id]); ?>
        </div>
        <div class="field-admanage-c_flash">
            <div class="form-group"><label>Flash上传</label></div>
            <?= File::widget(['value' => $model->c_content, 'object_id' => $model->c_id]); ?>
        </div>
        <?= $form->field($model, 'c_content')->textArea(['maxlength' => true, 'rows' => 3]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
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
            var url = $('.field-admanage-c_url');
            var picture = $('.field-admanage-c_picture');
            var flash = $('.field-admanage-c_flash');
            var html = $('.field-admanage-c_content');
            if (type === '1') {
                url.show();
                picture.hide();
                flash.hide();
                html.hide();
            } else if (type === '2') {
                url.hide();
                picture.show();
                flash.hide();
                html.hide();
            } else if (type === '3') {
                url.hide();
                picture.hide();
                flash.show();
                html.hide();
            } else if (type === '4') {
                url.hide();
                picture.hide();
                flash.hide();
                html.show();
            }
        }
        setShowHide('$model->c_type');
        $('#admanage-c_type input').on('click', function () {
            setShowHide($(this).val());
        });
    });
EOT;
backend\assets\AppAsset::addScript($js);
