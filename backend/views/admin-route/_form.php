<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use backend\models\AdminRoute;
use backend\widgets\SelectIcons;

$dropdown = AdminRoute::formatDropDownList();
$dropdown[0] = '顶级菜单';
$defaul_icon = 'option-horizontal';
if ($model->isNewRecord) {
    $model->c_status = 1;
    $model->c_sort = 0;
    $model->c_parent_id = (int) Yii::$app->request->get('parent_id', 0);
} else {
    $defaul_icon = $model->c_icon ? $model->c_icon : $defaul_icon;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_parent_id')->dropDownList($dropdown) ?>
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_route')->textInput(['maxlength' => true]) ?>
        <!--
        <i id="adminroute-c_icon-preview" class="glyphicon glyphicon-option-horizontal"></i> 预览图标
        -->
        <?= $form->field($model, 'c_icon', ['template' => '<span class="input-group-addon"><i id="adminroute-c_icon-preview" class="glyphicon glyphicon-' . $defaul_icon . '"></i></span>{input}<span class="input-group-btn"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#iconModal">选择图标</button></span>', 'options' => ['class' => 'form-group input-group col-xs-3']])->textInput(['maxlength' => true])->label(false) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<!--
['field' => 'adminroute-c_icon'] 保存图标字段ID
-->
<?= SelectIcons::widget(['field' => 'adminroute-c_icon']) ?>
