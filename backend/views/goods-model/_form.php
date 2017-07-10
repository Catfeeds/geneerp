<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($model->isNewRecord) {
    $model->c_sort = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-body">
        <div class="form-group">
            <button id="add-attr-btn" class="btn btn-sm" type="button"><i class="glyphicon glyphicon-plus"></i> 扩展属性</button>
        </div>
        <div id="box-attr-list" class="box box-solid box-default"></div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php
//初始化
$init = '';
if (isset($model->goodsModelAttr)) {
    foreach ($model->goodsModelAttr as $v) {
        $init .= 'addBody("' . $v->c_title . '", ' . $v->c_type . ' , "' . $v->c_value . '", ' . $v->c_search . ');';
    }
}
?>
<?php
$js = <<<EOT
    function addBody(title, type, value, search) {
        var guid = getGuid();
        var html = '<div class="box-body">';
        html += '<div class="form-group col-xs-2"><label class="control-label">属性名称</label><input type="text" class="form-control" name="GoodsModelAttr[title][]" maxlength="255" value="' + title + '"></div>';
        html += '<div class="form-group col-xs-2"><label class="control-label">类型</label><select class="form-control" name="GoodsModelAttr[type][]"><option value="1"' + (type === 1 ? ' selected="selected"' : '') + '>单选框</option><option value="2"' + (type === 2 ? ' selected="selected"' : '') + '>复选框</option><option value="3"' + (type === 3 ? ' selected="selected"' : '') + '>下拉框</option><option value="4"' + (type === 4 ? ' selected="selected"' : '') + '>输入框</option></select></div>      ';
        html += '<div class="form-group col-xs-4"><label class="control-label">属性值</label><input type="text" class="form-control" name="GoodsModelAttr[value][]" value="' + value + '"></div>   ';
        html += '<div class="form-group col-xs-2"><label class="control-label">是否支持搜索</label><div><label><input type="radio" name="GoodsModelAttr[search]['+guid+']" value="1"' + (search === 1 ? ' checked="checked"' : '') + '> 是</label> <label><input type="radio" name="GoodsModelAttr[search]['+guid+']" value="2"' + (search === 2 ? ' checked="checked"' : '') + '> 否</label></div></div>';
        html += '<div class="form-group col-xs-2"><label>操作</label><button class="btn btn-block btn-remove" type="button"><i class="glyphicon glyphicon-trash"></i> 移除</button></div></div>';
        $('#box-attr-list').append(html);
    }
    $(function () {
        //新增
        $('#add-attr-btn').on('click', function () {
            addBody('',1,'',2);
        });
        //删除
        $('#box-attr-list').on('click', '.btn-remove', function () {
            $(this).parent().parent().remove();
        });
        $init
    });
EOT;
backend\assets\AppAsset::addScript($js);
