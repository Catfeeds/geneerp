<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\GoodsCart;
use common\models\Order;
use common\models\Goods;
use common\models\Delivery;
use common\models\Upload;
use common\models\GoodsCategory;

$cart = GoodsCart::getCart();
if ($model->isNewRecord) {
    $model->c_admin_discount_amount = 0;
}
$display = $model->c_delivery_amount_type == 1 ? 'display:none' : '';
$display_invoice = $model->c_is_invoice == 2 ? 'display:none' : '';
?>

<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">订单商品</a></li>
    <li><a href="#tab2" data-toggle="tab">订单配置</a></li>
    <li><a href="#tab3" data-toggle="tab">收货人信息</a></li>
</ul>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body tab-content">
        <div class="tab-pane active" id="tab1">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="col-xs-1">ID</th>
                        <th>商品名称</th>
                        <th class="col-xs-2">缩略图</th>
                        <th class="col-xs-2" >单价</th>
                        <th class="col-xs-2">数量</th>
                        <th class="col-xs-1">操作</th>
                    </tr>
                </thead>
                <tbody id="goods_list">
                    <?php
                    if ($model->isNewRecord) {
                        foreach ($cart->itemList() as $k => $v) {
                            ?>
                            <tr id="goods_id_<?= $k ?>">
                                <td><?= $k ?></td>
                                <td><?= $v['title'] ?></td>
                                <td><img src="<?= Upload::getThumb($v['picture']) ?>" height="50"></td>
                                <td>￥<?= $v['price'] ?></td>
                                <td><input type="number" class="form-control" name="Order[goods_count][<?= $k ?>]" value="<?= $v['count'] ?>" min="1"></td>
                                <td><?= Html::button('<i class="glyphicon glyphicon-trash"></i> 本次移除', ['class' => 'btn btn-default btn-remove']) ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        foreach ($model->orderGoods as $v) {
                            ?>
                            <tr id="goods_id_<?= $v->c_goods_id ?>">
                                <td><?= $v->c_goods_id ?></td>
                                <td><?= $v->c_title ?></td>
                                <td><img src="<?= Upload::getThumb($v->c_picture) ?>" height="50"></td>
                                <td>￥<?= $v->c_sell_price ?></td>
                                <td><input type="number" class="form-control" name="Order[goods_count][<?= $v->c_goods_id ?>]" value="<?= $v->c_count ?>" min="1"></td>
                                <td><?= Html::button('<i class="glyphicon glyphicon-trash"></i> 移除', ['class' => 'btn btn-default btn-remove']) ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="row">
                                <div class="col-xs-3">
                                    <select id="select_goodscategory" class="form-control">
                                        <option value="">按商品类别</option>
                                        <?php
                                        foreach (GoodsCategory::formatDropDownList() as $k => $v) {
                                            ?>
                                            <option value="<?= $k ?>"><?= $v ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <select id="select_goods" class="form-control"></select>
                                </div>
                                <div class="col-xs-3"><?= Html::button('选择商品', ['class' => 'btn btn-sm btn-primary', 'id' => 'btn-add']) ?></div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="row">
                <?= $form->field($model, 'c_delivery_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList(Delivery::getKeyValueSortCache(), ['prompt' => '选择配送方式']) ?>
                <?= $form->field($model, 'c_delivery_amount_type', ['options' => ['class' => 'form-group col-xs-3']])->radioList(Order::getDeliveryAmountType()) ?>
                <?= $form->field($model, 'c_paid_freight_amount', ['options' => ['class' => 'form-group col-xs-3', 'style' => $display]])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'c_admin_discount_amount', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_accept_time', ['options' => ['class' => 'form-group col-xs-3']])->radioList(Order::getAcceptTime()) ?>
                <?= $form->field($model, 'c_is_invoice', ['options' => ['class' => 'form-group col-xs-3']])->radioList(Order::getInvoiceStatus()) ?>
                <?= $form->field($model, 'c_invoice_title', ['options' => ['class' => 'form-group col-xs-3', 'style' => $display_invoice]])->textInput(['maxlength' => true]) ?>
            </div>
            <?= $form->field($model, 'c_admin_note')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="tab-pane" id="tab3">
            <div class="row">
                <?php if ($model->isNewRecord) { ?>
                    <?= $form->field($model, 'c_user_name', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?php } ?>
                <?= $form->field($model, 'c_full_name', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_mobile', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_phone', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'c_province_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList([]) ?>
                <?= $form->field($model, 'c_city_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList([]) ?>
                <?= $form->field($model, 'c_area_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList([]) ?>
                <?= $form->field($model, 'c_postcode', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <?= $form->field($model, 'c_address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'c_user_note')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '创建订单' : '编辑订单', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$goods_json = json_encode(Goods::getGoodsByCategory(), JSON_UNESCAPED_UNICODE);
$js = <<<EOT
    var goods_json = $goods_json;
    var opts = {
        data: districtData,
        selClass: 'form-control',
        minWidth: 0,
        maxWidth: 0,
        autoHide :false,
        head: '请选择',
        select: ['#order-c_province_id', '#order-c_city_id', '#order-c_area_id'],
        defVal: [$model->c_province_id,$model->c_city_id,$model->c_area_id]
    };
    var linkageSel = new LinkageSel(opts);
    //写入邮编
    linkageSel.onChange(function () {
        $('#order-c_postcode').val(this.getSelectedData('zip'));
    });
    //选择商品类别筛选商品
    $('#select_goodscategory').change(function () {
       var val = $(this).val();
       $('#select_goods').empty();
       if (val && goods_json.hasOwnProperty(val)) {
            $('#select_goods').append('<option value="">请选择商品</option>');
            var goods_data = goods_json[val];
            $.each(goods_data, function(i, obj) {
                $('#select_goods').append('<option value="'+i+'">'+obj.c_title+'</option>');
            });
       }
    });
    //配送费用计算方式
    $('input[name="Order[c_delivery_amount_type]"]').on('click', function () {
        if($(this).val() == 2){
            $('.field-order-c_paid_freight_amount').show();
        }else{
            $('.field-order-c_paid_freight_amount').hide();
        }
    });
    //发票
    $('input[name="Order[c_is_invoice]"]').on('click', function () {
        if($(this).val() == 1){
            $('.field-order-c_invoice_title').show();
        }else{
            $('.field-order-c_invoice_title').hide();
        }
    });
    function addBody(json){
        var html = '';
        html +='<tr id="goods_id_'+json.c_goods_id+'"><td>'+json.c_goods_id+'</td>';
        html +='<td>'+json.c_title+'</td>';
        html +='<td><img src="'+json.c_picture+'" height="50"></td>';
        html +='<td>￥'+json.c_sell_price+'</td>';
        html +='<td><input type="number" class="form-control" name="Order[goods_count]['+json.c_goods_id+']" value="'+json.c_count+'" min="1"></td>';
        html +='<td><button type="submit" class="btn btn-default btn-remove"><i class="glyphicon glyphicon-trash"></i> 移除</button></td>';
        $('#goods_list').append(html);
    }
    $('#btn-add').on('click', function () {
        var category_id = $('#select_goodscategory').val();
        var goods_id = $('#select_goods').val();
        //console.log(category_id);
        //console.log(goods_id);
        if (category_id && goods_id && goods_json.hasOwnProperty(category_id)) {
            if($('#goods_id_'+goods_id).length > 0){
                bootbox.alert('商品已存在，请直接修改商品数量');
            }else{
                var goods_data = goods_json[category_id];
                if(goods_data.hasOwnProperty(goods_id)){
                    addBody(goods_data[goods_id]);
                }
            }
       }else{
            bootbox.alert('请选择商品分类，再选择商品');
       }
    });
    //删除订单商品
    $('#goods_list').on('click', '.btn-remove', function () {
        $(this).parent().parent().remove();
    });
EOT;
backend\assets\AppAsset::addScript($js);
