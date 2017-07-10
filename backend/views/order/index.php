<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Order;
use common\models\Delivery;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '订单列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['OrderSearch']['pagesize']) ? $get['OrderSearch']['pagesize'] : '';
$keyword = isset($get['OrderSearch']['keyword']) ? trim($get['OrderSearch']['keyword']) : '';
$order_status = isset($get['OrderSearch']['order_status']) ? $get['OrderSearch']['order_status'] : '';
$order_type = isset($get['OrderSearch']['order_type']) ? $get['OrderSearch']['order_type'] : '';
$pay_status = isset($get['OrderSearch']['pay_status']) ? $get['OrderSearch']['pay_status'] : '';
$delivery_id = isset($get['OrderSearch']['delivery_id']) ? $get['OrderSearch']['delivery_id'] : '';
$distribution_status = isset($get['OrderSearch']['distribution_status']) ? $get['OrderSearch']['distribution_status'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'order_status')->dropDownList(Order::getOrderStatusText(), ['prompt' => '选择订单状态', 'value' => $order_status]) ?>
            <?= $form->field($searchModel, 'order_type')->dropDownList(Order::getOrderType(), ['prompt' => '选择订单类型', 'value' => $order_type]) ?>
            <?= $form->field($searchModel, 'pay_status')->dropDownList(Order::getPayStatus(), ['prompt' => '选择支付状态', 'value' => $pay_status]) ?>
            <?= $form->field($searchModel, 'delivery_id')->dropDownList(Delivery::getKeyValueCache(), ['prompt' => '选择配送方式', 'value' => $delivery_id]) ?>
            <?= $form->field($searchModel, 'distribution_status')->dropDownList(Order::getDistributionStatus(), ['prompt' => '选择配送状态', 'value' => $distribution_status]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('order/create')) { ?>
            <div class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', Url::to(['create']), ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="box-body">
        <?php Pjax::begin(); ?> 
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'c_id',
                    'headerOptions' => ['style' => 'min-width:50px']
                ],
                [
                    'attribute' => 'c_order_no',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_order_no) : $model->c_order_no;
                    }
                ],
                [
                    'attribute' => 'c_user_name',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword && $model->c_user_name ? Util::highlight($keyword, $model->c_user_name) : $model->c_user_name;
                    }
                ],
                [
                    'attribute' => 'c_full_name',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_full_name) : $model->c_full_name;
                    }
                ],
                [
                    'attribute' => 'c_mobile',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword && $model->c_mobile ? Util::highlight($keyword, $model->c_mobile) : $model->c_mobile;
                    }
                ],
                [
                    'attribute' => 'c_phone',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword && $model->c_phone ? Util::highlight($keyword, $model->c_phone) : $model->c_phone;
                    }
                ],
                [
                    'attribute' => 'c_order_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Order::getOrderType($model->c_order_type);
                    },
                ],
                [
                    'attribute' => 'c_order_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Order::getOrderStatusText($model->c_order_status);
                    },
                ],
                [
                    'attribute' => 'c_pay_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Order::getPayStatus($model->c_pay_status);
                    },
                ],
                [
                    'attribute' => 'c_payment_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->payment->c_title) ? $model->payment->c_title : '--';
                    },
                ],
                [
                    'attribute' => 'c_distribution_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Order::getDistributionStatus($model->c_distribution_status);
                    },
                ],
                [
                    'attribute' => 'c_delivery_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->delivery->c_title) ? $model->delivery->c_title : '--';
                    },
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{update}</span><span class="pr20">{view}</span>',
                    'visibleButtons' => [
                        'update' => CheckRule::checkRole('order/update'),
                        'view' => CheckRule::checkRole('order/view')
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            if ($model->c_order_status == Order::STATUS_WAIT_PAY && $model->c_pay_status == Order::STATUS_NO) {
                                $options = ['title' => '编辑订单', 'aria-label' => '编辑订单', 'data-pjax' => '0'];
                                return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, $options);
                            }
                        }]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
    </div>
</div>