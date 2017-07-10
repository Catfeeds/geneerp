<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use common\models\Delivery;

if ($model->isNewRecord) {
    $model->c_status = $model->c_price_type = $model->c_open_default = 1;
    $model->c_sort = $model->c_insured_rate = $model->c_low_price = $model->c_first_price = $model->c_second_price = 0;
    $model->c_is_insured = 2;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_type')->radioList(Delivery::getType()) ?>
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">设置重量与费用</h3>
                根据重量来计算运费，当物品不足【首重重量】时，按照【首重费用】计算，超过部分按照【续重重量】和【续重费用】乘积来计算
            </div>
            <div class="box-body">
                <?= $form->field($model, 'c_first_weight', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList(Delivery::getWeight()) ?>
                <?= $form->field($model, 'c_first_price', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_second_weight', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList(Delivery::getWeight()) ?>
                <?= $form->field($model, 'c_second_price', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <?= $form->field($model, 'c_is_insured')->checkbox(['class' => 'show-hide', 'data-showhide' => 'box-insured']) ?>
        <div id="box-insured" class="box box-solid box-default"<?= $model->c_is_insured == 1 ? : ' style="display:none"' ?>>
            <div class="box-header">
                <h3 class="box-title">设置物流保价</h3> 当用户需要保价后，一般是按照货物总金额的【保价费率】计算，但是保价金额最低不低于【最低保价】
            </div>
            <div class="box-body">
                <?= $form->field($model, 'c_insured_rate', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_low_price', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <?= $form->field($model, 'c_price_type')->radioList(Delivery::getPriceType()) ?>
        <div id="box-areas" class="box box-solid box-default"<?= $model->c_price_type == 1 ? : ' style="display:none"' ?>>
            <div class="box-header">
                <h3 class="box-title">设置支持的配送地区</h3> 注意：如果不开启【其他地区启用默认费用】，那么未设置的地区将无法送达
            </div>
            <div class="box-body">
                <button id="add-areas-btn" class="btn btn-sm" type="button"><i class="glyphicon glyphicon-plus"></i> 配送地区</button>
                <?= $form->field($model, 'c_open_default')->checkbox() ?>
                <div id="box-areas-list"></div>
            </div>
        </div>

        <?= $form->field($model, 'c_description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
//初始化
$init = '';
if ($model->c_price_type == 2 && $model->c_area_id_array) {
    $area_id_array = json_decode($model->c_area_id_array);
    $first_price_array = json_decode($model->c_first_price_array);
    $second_price_array = json_decode($model->c_second_price_array);
    foreach ($area_id_array as $key => $value) {
        $init .= 'addBody(' . $key . ', "' . $value . '" , ' . $first_price_array[$key] . ', ' . $second_price_array[$key] . ');';
    }
}
?>
<?php
$js = <<<EOT
    function setSelect(guid) {
        $('#province' + guid).chosen({search_contains: true}).change(function () {
            $('#area_id_array' + guid).val($(this).val());
        });
    }
    function initSelect(guid,ids) {
        var id_array = '';
        if(ids){
            id_array = ids.split(',');
        }
        var html = '';
        html += '<select class="form-control" id="province' + guid + '" multiple="multiple">';
        $.each(districtData1, function (id, json) {
            var selectstr ='';
            if(id_array && id_array.indexOf(id) !== -1){
                selectstr = ' selected="selected"';
            }
            html += '<option value="' + id + '"' + selectstr + '>' + json.name + '</option>';
        });
        html += '</select>';
        return html;
    }
    function addBody(guid, ids, first_price, second_price) {
        var html = '';
        html += '<div class="box box-solid box-default"><div class="box-body">';
        html += '<div class="form-group col-xs-12"><label class="control-label">选择地区</label>';
        html += initSelect(guid,ids);
        html += '</div>';
        html += '<div class="form-group col-xs-3"><label>首重费用(元)</label><input type="text" class="form-control" name="first_price_array[]" value="' + first_price + '"></div>';
        html += '<div class="form-group col-xs-3"><label>续重费用(元)</label><input type="text" class="form-control" name="second_price_array[]" value="' + second_price + '"></div>';
        html += '<div class="form-group col-xs-2"><label>操作</label><button class="btn btn-block btn-remove" type="button"><i class="glyphicon glyphicon-trash"></i> 移除</button></div>';
        html += '<input id="area_id_array' + guid + '" type="hidden" name="area_id_array[]" value="' + ids + '"></div></div>';
        $('#box-areas-list').append(html);
        setSelect(guid);
    }
    function setPriceType(type) {
        if (type === '2') {
            $('#box-areas').show();
        } else {
            $('#box-areas').hide();
        }
    }
    $(function () {
        setPriceType('$model->c_price_type');
        $('#delivery-c_price_type input').on('click', function () {
            setPriceType($(this).val());
        });
        //新增地区
        $('#add-areas-btn').on('click', function () {
            var guid = getGuid();
            addBody(guid,0,0,0);
        });
        //删除
        $('#box-areas-list').on('click', '.btn-remove', function () {
            $(this).parent().parent().parent().remove();
        });
        $init
    });
EOT;
backend\assets\AppAsset::addScript($js);


