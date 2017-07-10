<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GoodsCategory;

if ($model->isNewRecord) {
    $model->c_sort = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_goods_category_id')->dropDownList(GoodsCategory::formatDropDownList(), ['prompt' => '选择商品类别']) ?>
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>