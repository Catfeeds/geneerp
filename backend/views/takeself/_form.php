<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;

if ($model->isNewRecord) {
    $model->c_status = 1;
    $model->c_sort = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <div class="clearfix">
            <?= $form->field($model, 'c_province_id', ['options' => ['class' => 'form-group col-xs-4']])->dropDownList([]) ?>
            <?= $form->field($model, 'c_city_id', ['options' => ['class' => 'form-group col-xs-4']])->dropDownList([]) ?>
            <?= $form->field($model, 'c_area_id', ['options' => ['class' => 'form-group col-xs-4']])->dropDownList([]) ?>
        </div>
        <?= $form->field($model, 'c_address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_mobile')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_phone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$default = $model->isNewRecord ? '' : ',defVal: [' . $model->c_province_id . ',' . $model->c_city_id . ',' . $model->c_area_id . ']';
$js = <<<EOT
    var opts = {
        data: districtData,
        selClass: 'form-control',
        minWidth: 0,
        maxWidth: 0,
        autoHide :false,
        head: '请选择',
        select: ['#takeself-c_province_id', '#takeself-c_city_id', '#takeself-c_area_id']$default
    };
    new LinkageSel(opts);
EOT;
backend\assets\AppAsset::addScript($js);
