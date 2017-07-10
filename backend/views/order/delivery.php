<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\GridView;
use common\models\FreightCompany;
use common\models\OrderGoods;
use common\models\DeliveryDoc;
use common\models\Upload;

$this->title = '订单发货';
$this->params['breadcrumbs'][] = ['label' => '查看订单', 'url' => ['view', 'id' => $model->c_id]];
$form = ActiveForm::begin();
$delivery = new DeliveryDoc();
?>
<div class="box box-primary">
    <div class="box-body">
        <?=
        GridView::widget([
            'layout' => '{items}',
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'c_id',
                    'headerOptions' => ['style' => 'min-width:50px']
                ],
                'c_title',
                [
                    'attribute' => 'c_picture',
                    'format' => ['image', ['height' => 50]],
                    'value' => function ($model) {
                return Upload::getThumb($model->c_picture);
            }
                ],
                'c_number', 'c_sell_price', 'c_real_price', 'c_count',
                [
                    'label' => '小计',
                    'attribute' => 'c_count',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->c_count * $model->c_real_price;
                    },
                ],
                [
                    'attribute' => 'c_is_send',
                    'format' => 'raw',
                    'value' => function($model) {
                        return OrderGoods::getSendStatus($model->c_is_send);
                    },
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'name' => 'DeliveryDoc[order_goods_id]', //设置每行数据的复选框属性
                    'checkboxOptions' => function($model, $key, $index, $column) {
                        return ['checked' => $model->c_is_send == OrderGoods::STATUS_SEND_NO, 'disabled' => $model->c_is_send != OrderGoods::STATUS_SEND_NO];
                    }
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">发货操作</div>
            <div class="box-body">
                <div class="row">
                    <?= $form->field($delivery, 'c_full_name', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true, 'value' => $model->c_full_name]) ?>
                    <?= $form->field($delivery, 'c_mobile', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true, 'value' => $model->c_mobile]) ?>
        <?= $form->field($delivery, 'c_phone', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true, 'value' => $model->c_phone]) ?> 
                </div>
                <div class="row">
                    <?= $form->field($delivery, 'c_province_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList([]) ?>
                    <?= $form->field($delivery, 'c_city_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList([]) ?>
                    <?= $form->field($delivery, 'c_area_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList([]) ?>
                <?= $form->field($delivery, 'c_postcode', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true, 'value' => $model->c_postcode]) ?>
                </div>
                    <?= $form->field($delivery, 'c_address')->textInput(['maxlength' => true, 'value' => $model->c_address]) ?>
                <div class="row">
                    <?= $form->field($delivery, 'c_freight_id', ['options' => ['class' => 'form-group col-xs-3']])->dropDownList(FreightCompany::getKeyValueSortCache()) ?>
                <?= $form->field($delivery, 'c_delivery_code', ['options' => ['class' => 'form-group col-xs-3']])->textInput(['maxlength' => true]) ?>
                </div>
                <?= $form->field($delivery, 'c_note')->textArea(['maxlength' => true, 'rows' => 3]) ?>
            <?= Html::submitButton('发货', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
        </div>
        <?php
        $js = <<<EOT
    var opts = {
        data: districtData,
        selClass: 'form-control',
        minWidth: 0,
        maxWidth: 0,
        autoHide :false,
        head: '请选择',
        select: ['#deliverydoc-c_province_id', '#deliverydoc-c_city_id', '#deliverydoc-c_area_id'],
        defVal: [$model->c_province_id,$model->c_city_id,$model->c_area_id]
    };
    var linkageSel = new LinkageSel(opts);
    //写入邮编
    linkageSel.onChange(function () {
        $('#deliverydoc-c_postcode').val(this.getSelectedData('zip'));
    });
EOT;
        backend\assets\AppAsset::addScript($js);
        