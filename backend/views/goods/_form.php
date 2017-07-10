<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\uploader\Picture;
use common\widgets\uploader\Pictures;
use common\widgets\editor\Editor;
use common\models\Goods;
use common\models\GoodsCategory;
use common\models\GoodsCategoryExtend;
use common\models\GoodsBrand;
use common\models\GoodsModel;
use common\models\GoodsLabel;
use common\models\GoodsModelAttr;

$category_id = 0;
if ($model->isNewRecord) {
    $model->c_status = 2;
    $model->c_sort = $model->c_point = $model->c_exp = $model->c_market_price = $model->c_sell_price = $model->c_cost_price = $model->c_store_count = $model->c_weight = 0;
    $model->c_unit = '件';
    $model->c_number = Goods::createGoodsNumber();
} else {
    $category_id = GoodsCategoryExtend::getColumn('c_category_id', ['c_goods_id' => $model->c_id]);
}
?>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">基本信息</a></li>
    <li><a href="#tab2" data-toggle="tab">图片上传</a></li>
    <li><a href="#tab3" data-toggle="tab">编辑内容</a></li>
    <li><a href="#tab4" data-toggle="tab">优化设置</a></li>
</ul>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'editer_form']]); ?>
    <div class="box-body tab-content">
        <div class="tab-pane active" id="tab1">
            <?= $form->field($model, 'category')->dropDownList(GoodsCategory::formatDropDownList(), ['multiple' => true, 'value' => $category_id]) ?>
            <div class="row">
                <?= $form->field($model, 'c_brand_id', ['options' => ['class' => 'form-group col-xs-6']])->dropDownList(GoodsBrand::getKeyValueCache(), ['prompt' => '选择品牌']) ?>
                <?= $form->field($model, 'c_model_id', ['options' => ['class' => 'form-group col-xs-6']])->dropDownList(GoodsModel::getKeyValueCache(), ['prompt' => '选择模型']) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'c_title', ['options' => ['class' => 'form-group col-xs-6']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_number', ['options' => ['class' => 'form-group col-xs-6']])->textInput(['maxlength' => true]) ?> 
            </div>
            <div class="row">
                <?= $form->field($model, 'c_market_price', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_sell_price', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_cost_price', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_store_count', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'c_point', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_exp', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_weight', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_unit', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div id="model_attr" style="display:none"></div>
            <?= $form->field($model, 'label')->checkboxList(Goods::getLabel(), ['value' => GoodsLabel::getColumn('c_type', ['c_goods_id' => $model->c_id])]) ?>
            <?= $form->field($model, 'c_status')->radioList(Goods::getStatus()) ?>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="field-goods-c_picture">
                <div class="form-group"><label>商品相册</label></div>
                <?= Pictures::widget(['value' => $model->c_picture, 'object_id' => $model->c_id]); ?>
            </div>
            <div class="field-goods-c_ad_picture">
                <div class="form-group"><label>广告图片</label></div>
                <?= Picture::widget(['name' => 'ad_picture', 'value' => $model->c_ad_picture, 'object_id' => $model->c_id]); ?>
            </div>
        </div>
        <div class="tab-pane" id="tab3">
            <div class="field-content-c_pc_content">
                <div class="form-group"><label>PC内容</label></div>
                <?= Editor::widget(['value' => isset($model->goodsText) ? $model->goodsText->c_pc_content : '', 'object_id' => $model->c_id, 'name' => 'pc_content']); ?>
            </div>
            <div class="field-content-c_h5_content">
                <div class="form-group"><label>H5内容</label></div>
                <?= Editor::widget(['value' => isset($model->goodsText) ? $model->goodsText->c_h5_content : '', 'object_id' => $model->c_id, 'name' => 'h5_content']); ?>
            </div>
            <div class="field-content-c_app_content">
                <div class="form-group"><label>APP内容</label></div>
                <?= Editor::widget(['value' => isset($model->goodsText) ? $model->goodsText->c_app_content : '', 'object_id' => $model->c_id, 'name' => 'app_content']); ?>
            </div>
        </div>
        <div class="tab-pane" id="tab4">
            <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_search_keyword')->textInput(['maxlength' => true]) ?>
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
//初始化
$default_attr = [];
if (isset($model->goodsAttr)) {
    foreach ($model->goodsAttr as $v) {
        $default_attr[$v->c_attr_id] = $v->c_attr_value;
    }
}
$init = 'addBody(' . $model->c_model_id . ');';
?>
<?php
$model_attr = json_encode(GoodsModelAttr::getModelAttr($default_attr), JSON_UNESCAPED_UNICODE);
$js = <<<EOT
$(function () {
    //商品类别下拉处理
    $('#goods-category').chosen({search_contains: true});   
    function addBody(model_id){
        var model_attr_json = $model_attr; //所有模型属性的数据
        //console.log(model_attr_json);
        if (model_id > 0) {
            var html = '';
            if (model_attr_json.hasOwnProperty(model_id)) {//model_id是否存在
                var attr_data = model_attr_json[model_id]; //选中的模型数据
                if (attr_data.length > 0) {//判断内容是否为空
                    $('#model_attr').show();
                    $.each(attr_data, function (index, item) {
                        var default_value = item.default;
                        html += '<div class="form-group"><label class="control-label">' + item.title + '</label><div>';
                        if (item.type !== '4') {
                            if (item.type === '3') {
                                html += '<select class="form-control" name="Goods[goods_attr][3][' + item.id + ']"><option value="">请选择' + item.title + '</option>';
                            }
                            $.each(item.value, function (i, title) {
                                if (item.type === '1') {
                                    html += '<label class="radio-inline"><input type="radio" name="Goods[goods_attr][1][' + item.id + ']" value="' + title + '"' + (default_value === title ? ' checked="checked"' : '') + '>' + title + '</label>';
                                } else if (item.type === '2') {
                                    html += '<label class="checkbox-inline"><input type="checkbox" name="Goods[goods_attr][2][' + item.id + '][]" value="' + title + '"' + ($.inArray( title, default_value ) !==-1 ? ' checked="checked"' : '') + '>' + title + '</label>';
                                } else if (item.type === '3') {
                                    html += '<option value="' + title + '"' + (default_value === title ? ' selected="selected"' : '') + '>' + title + '</option>';
                                }
                            });
                            if (item.type === '3') {
                                html += '</select>';
                            }
                        } else {
                            html += '<input type="text" class="form-control" name="Goods[goods_attr][4][' + item.id + ']" value="' + (default_value?default_value:item.value) + '" placeholder="请输入相关信息">';
                        }
                        html += '</div></div>';
                    });
                }
            }
            $('#model_attr').html(html);
        } else {
            $('#model_attr').hide();
        }
    }
    //商品模型选择触发
    $('#goods-c_model_id').change(function () {
        addBody($(this).val());//选中的模型ID
    });
    $init
});
EOT;
backend\assets\AppAsset::addScript($js);

