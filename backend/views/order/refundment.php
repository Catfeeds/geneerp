<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\widgets\GridView;
use common\models\Upload;
use common\models\OrderGoods;
use common\models\RefundmentDoc;

$this->title = '订单退款';
$this->params['breadcrumbs'][] = ['label' => '查看订单', 'url' => ['view', 'id' => $model->c_id]];

$form = ActiveForm::begin();
$refundment = new RefundmentDoc();
$refundment->c_way = 1;
$refundment->c_type = 1;
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
                    'name' => 'RefundmentDoc[order_goods_id]', //设置每行数据的复选框属性
                    'checkboxOptions' => function($model, $key, $index, $column) {
                        return ['checked' => $model->c_is_send == OrderGoods::STATUS_SEND_YES, 'disabled' => $model->c_is_send != OrderGoods::STATUS_SEND_YES];
                    }
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">订单信息</div>
            <div class="box-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'c_order_no',
                        'c_order_amount',
                        'c_user_name',
                        'c_full_name',
                        'c_mobile',
                        ['label' => $model->getAttributeLabel('c_create_time'), 'value' => date('Y-m-d H:i:s', $model->c_create_time)],
                    ],
                ])
                ?>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">退款操作</div>
            <div class="box-body">
                <div class="row">
                    <?= $form->field($refundment, 'c_way', ['options' => ['class' => 'form-group col-xs-3']])->radioList(RefundmentDoc::getWay()) ?>
                    <?= $form->field($refundment, 'c_type', ['options' => ['class' => 'form-group col-xs-3']])->radioList(RefundmentDoc::getType()) ?>
                    <?= $form->field($refundment, 'c_amount', ['options' => ['class' => 'form-group col-xs-3', 'style' => 'display:none']])->textInput(['maxlength' => true]) ?>
                </div>
                <?= $form->field($refundment, 'c_note')->textArea(['maxlength' => true, 'rows' => 3]) ?>
                <?= Html::submitButton('退款', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <?php
        $js = <<<EOT
$(function () {
    $('input[name="RefundmentDoc[c_type]"]').on('click', function () {
        if ($(this).val() === '2') {
            $('.field-refundmentdoc-c_amount').show();
        } else {
            $('#refundmentdoc-c_amount').val('');
            $('.field-refundmentdoc-c_amount').hide();
        }
    });
});
EOT;
        backend\assets\AppAsset::addScript($js);
        