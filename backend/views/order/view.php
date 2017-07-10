<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Areas;
use common\models\User;
use common\models\Payment;
use common\models\Order;
use common\models\OrderGoods;
use common\models\OrderLog;
use common\models\RefundmentDoc;
use common\models\CollectionDoc;

$areas = Areas::getAreaTitle([$model->c_province_id, $model->c_city_id, $model->c_area_id]);
$order_status = Order::getDiyOrderStatus($model->c_id, $model->c_order_status, $model->c_distribution_status, $model->c_payment_id);
$this->title = '查看订单';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
?>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">基本信息</a></li>
    <li><a href="#tab2" data-toggle="tab">收退款记录</a></li>
    <li><a href="#tab3" data-toggle="tab">发货记录</a></li>
    <li><a href="#tab4" data-toggle="tab">附言备注</a></li>
    <li><a href="#tab5" data-toggle="tab">订单日志</a></li>
    <li class="pull-right">
        <?php
        /**
          0 => '未知',
          1 => '货到付款待发货', //未付款等待发货(货到付款)
          2 => '待付款', //等待付款(线上支付)
          3 => '已发货', //已发货(已付款)
          4 => '已付款待发货', //已付款等待发货
          5 => '已取消', //已取消
          6 => '已完成', //已完成(已付款,已收货)
          7 => '全额退款', //全部退款
          8 => '部分发货', //部分发货(货到付款+已经付款)
          9 => '部分退款', //部分退款(未发货+部分发货)
          10 => '部分退款', //部分退款(全部发货)
          11 => '货到付款已发货', //已发货(货到付款)
          12 => '申请退款', //未处理的退款申请
         */
        if (CheckRule::checkRole('order/pay') && in_array($order_status, [2, 11])) {
            ?>
            <?= Html::button('支付', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#orderPay']) ?>
        <?php } ?>
        <?php if (CheckRule::checkRole('order/finish') && in_array($order_status, [3, 11])) { ?>
            <button class="btn btn-primary btn-confirm" data-title="确认订单完成？" data-url="<?= Url::to(['finish', 'id' => $model->c_id]); ?>" type="button">完成</button>
        <?php } ?>
        <?php if (CheckRule::checkRole('order/cancel') && in_array($order_status, [1, 2])) { ?>
            <button class="btn btn-danger btn-confirm" data-title="确认订单取消？" data-url="<?= Url::to(['cancel', 'id' => $model->c_id]); ?>" type="button">取消</button>
        <?php } ?>

    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab1">
        <div class="box box-primary">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>货号</th>
                        <th>商品原价</th>
                        <th>实际价格</th>
                        <th>商品数量</th>
                        <th>小计</th>
                        <th>配送方式</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($model->orderGoods as $v) {
                        ?>
                        <tr>
                            <td><?= $v->c_title ?></td>
                            <td><?= $v->c_number ?></td>
                            <td>￥<?= $v->c_sell_price ?></td>
                            <td>￥<?= $v->c_real_price ?></td>
                            <td><?= $v->c_count ?></td>
                            <td>￥<?= $v->c_count * $v->c_real_price ?></td>
                            <td>
                                <?= OrderGoods::getSendStatus($v->c_is_send) ?>
                                <?php if ($v->c_delivery_doc_id) { ?>
                                    快递跟踪
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($model->c_order_status == Order::STATUS_WAIT_PAY && $model->c_pay_status == Order::STATUS_NO) { ?>
                                    <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', Url::to(['update', 'id' => $model->c_id])) ?>
                                <?php } ?>
                                <?php if (CheckRule::checkRole('order/delivery') && in_array($order_status, [1, 4, 8, 9]) && $v->c_is_send == OrderGoods::STATUS_SEND_NO) { ?>
                                    <?= Html::a('发货', Url::to(['delivery', 'id' => $model->c_id]), ['class' => 'btn btn-success']) ?>
                                <?php } ?>
                                <?php if (CheckRule::checkRole('order/refundment') && in_array($order_status, [4, 6, 9, 10]) && $v->c_is_send == OrderGoods::STATUS_SEND_YES) { ?>
                                    <?= Html::a('退款', Url::to(['refundment', 'id' => $model->c_id]), ['class' => 'btn btn-danger']) ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-xs-2">
                <div class="box box-primary">
                    <div class="box-header">订单信息</div>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>订单号</th>
                            <td><?= $model->c_order_no ?></td>
                        </tr>
                        <tr>
                            <th>订单状态</th>
                            <td class="text-danger"><?= Order::getDiyOrderStatusText($model->c_id, $model->c_order_status, $model->c_distribution_status, $model->c_payment_id); ?></td>
                        </tr>
                        <tr>
                            <th>支付状态</th>
                            <td class="text-danger"><?= Order::getOrderPayStatusText($model->c_order_status, $model->c_pay_status) ?></td>
                        </tr>
                        <tr>
                            <th>支付方式</th>
                            <td><?= isset($model->payment->c_title) ? $model->payment->c_title : '--' ?></td>
                        </tr>
                        <tr>
                            <th>配送状态</th>
                            <td><?= Order::getDistributionStatus($model->c_distribution_status) ?></td>
                        </tr>
                        <tr>
                            <th>订单类型</th>
                            <td><?= Order::getOrderType($model->c_order_type) ?></td>
                        </tr>
                        <tr>
                            <th>创建类型</th>
                            <td><?= Order::getCreateType($model->c_create_type) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="box box-primary">
                    <div class="box-header">订单金额明细</div>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th class="w100">商品总额</th>
                            <td>应付:￥<?= $model->c_payable_goods_amount ?><br>实付:￥<?= $model->c_paid_goods_amount ?></td>
                        </tr>
                        <tr>
                            <th>配送费用</th>
                            <td>应付:￥<?= $model->c_payable_freight_amount ?><br>实付:￥<?= $model->c_paid_freight_amount ?></td>
                        </tr>
                        <?php if ($model->c_insured_amount > 0) { ?>
                            <tr>
                                <th>保价费用</th>
                                <td>￥<?= $model->c_insured_amount ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($model->c_is_invoice === 1 && $model->c_tax_amount > 0) { ?>  
                            <tr>
                                <th>发票税金</th>
                                <td>￥<?= $model->c_tax_amount ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($model->c_card_id) { ?>
                            <tr>
                                <th>代金券面值</th>
                                <td>￥<?= $model->c_card_amount ?></td>
                            </tr>
                        <?php } ?>
                        <?php
                        if ($model->c_admin_discount_amount != 0) {
                            if ($model->c_admin_discount_amount > 0) {
                                ?>
                                <tr>
                                    <th>增加订单金额</th>
                                    <td>+ ￥<?= $model->c_admin_discount_amount ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <th>减少订单金额</th>
                                    <td>- ￥<?= abs($model->c_admin_discount_amount) ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <?php if ($model->c_promotion_amount > 0) { ?>
                            <tr>
                                <th>优惠总额</th>
                                <td>- ￥<?= $model->c_promotion_amount ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>订单总额</th>
                            <td>应付:￥<?= $model->c_payable_order_amount ?><br>实付:￥<?= isset($model->collectionDoc->c_amount) ? $model->collectionDoc->c_amount : 0 ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="box box-primary">
                    <div class="box-header">配送信息</div>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th class="w100">配送方式</th>
                            <td><?= isset($model->delivery->c_title) ? $model->delivery->c_title : '--' ?></td>
                        </tr>
                        <tr>
                            <th>商品重量</th>
                            <td><?= Util::formatWeight($model->c_weight) ?></td>
                        </tr>
                        <tr>
                            <th>配送费用</th>
                            <td>￥<?= $model->c_paid_freight_amount ?></td>
                        </tr>
                        <tr>
                            <th>是否开票</th>
                            <td><?= Order::getInvoiceStatus($model->c_is_invoice) ?></td>
                        </tr>
                        <?php if ($model->c_is_invoice == 1) { ?>
                            <tr>
                                <th>发票抬头</th>
                                <td><?= $model->c_invoice_title ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>可得积分</th>
                            <td><?= $model->c_point ?></td>
                        </tr>
                        <tr>
                            <th>可得经验</th>
                            <td><?= $model->c_exp ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="box box-primary">
                    <div class="box-header">收货人信息</div>
                    <table class="table table-hover table-striped">
                        <tr>
                            <th class="w100">发货日期</th>
                            <td><?= $model->c_send_time ? date('Y-m-d H:i:s', $model->c_send_time) : '--'; ?></td>
                        </tr>
                        <tr>
                            <th>姓名</th>
                            <td><?= $model->c_full_name ?></td>
                        </tr>
                        <tr>
                            <th>手机</th>
                            <td><?= $model->c_mobile ?></td>
                        </tr>
                        <tr>
                            <th>电话</th>
                            <td><?= $model->c_phone ?></td>
                        </tr>
                        <tr>
                            <th>区域</th>
                            <td><?= implode(' ', $areas) ?></td>
                        </tr>
                        <tr>
                            <th>地址</th>
                            <td><?= $model->c_address ?></td>
                        </tr>
                        <tr>
                            <th>邮编</th>
                            <td><?= $model->c_postcode ? $model->c_postcode : '' ?></td>
                        </tr>
                        <tr>
                            <th>送货时间</th>
                            <td><?= Order::getAcceptTime($model->c_accept_time) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="box box-primary">
                    <div class="box-header">用户信息</div>
                    <table class="table table-striped table-hover">
                        <?php if ($model->c_user_id && CheckRule::checkRole('user/amount')) { ?>
                            <tr>
                                <th>账户管理</th>
                                <td><?= Html::a('<i class="glyphicon glyphicon-credit-card"></i>', Url::to(['user/amount', 'id' => $model->c_user_id]), ['title' => '账户管理']) ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>用户名</th>
                            <td><?= isset($model->user->c_user_name) ? $model->user->c_user_name : '游客' ?></td>
                        </tr>
                        <?php if (isset($model->user->c_user_name)) { ?>
                            <tr>
                                <th>手机</th>
                                <td><?= User::getVerifyStatus($model->user->c_mobile_verify) . $model->user->c_mobile ?></td>
                            </tr>
                            <tr>
                                <th>邮箱</th>
                                <td><?= User::getVerifyStatus($model->user->c_email_verify) . $model->user->c_email ?></td>
                            </tr>
                            <tr>
                                <th>用户组</th>
                                <td><?= isset($model->user->userGroup->c_title) ? $model->user->userGroup->c_title : '--' ?></td>
                            </tr>
                            <tr>
                                <th>积分</th>
                                <td><?= isset($model->user->userAcount->c_point) ? $model->user->userAcount->c_point : '--' ?></td>
                            </tr>
                            <tr>
                                <th>经验</th>
                                <td><?= isset($model->user->userAcount->c_exp) ? $model->user->userAcount->c_exp : '--' ?></td>
                            </tr>
                            <tr>
                                <th>现金账户</th>
                                <td><?= isset($model->user->userAcount->c_amount) ? $model->user->userAcount->c_amount : '--' ?></td>
                            </tr>
                            <tr>
                                <th>注册时间</th>
                                <td><?= date('Y-m-d H:i:s', $model->user->c_create_time) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab2">
        <div class="box box-primary">
            <div class="box-header">收款单据</div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>金额</th>
                        <th>状态</th>
                        <th>支付方式</th>
                        <th>付款时间</th>
                        <th>备注</th>
                    </tr>
                </thead>
                <?php if ($model->collectionDoc) { ?>
                    <tr>
                        <td>￥<?= $model->collectionDoc->c_amount ?></td>
                        <td><?= Order::getPayStatus($model->collectionDoc->c_pay_status) ?></td>
                        <td><?= isset($model->collectionDoc->payment->c_title) ? $model->collectionDoc->payment->c_title : '--' ?></td>
                        <td><?= date('Y-m-d H:i:s', $model->collectionDoc->c_create_time) ?></td>
                        <td><?= $model->collectionDoc->c_note ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="box box-primary">
            <div class="box-header">退款单据</div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>退款商品</th>
                        <th>退款金额</th>
                        <th>退款方式</th>
                        <th>状态</th>
                        <th>申请时间</th>
                        <th>退款理由</th>
                        <th>处理意见</th>
                        <th>备注</th>
                    </tr>
                </thead>
                <?php
                if ($model->refundmentDoc) {
                    foreach ($model->refundmentDoc as $refundment) {
                        ?>
                        <tr>
                            <td>
                                <?php
                                $order_goods = OrderGoods::getOrderGoods($refundment->c_order_goods_id);
                                foreach ($order_goods as $goods) {
                                    ?>
                                    <p><?= $goods->c_number; ?> <?= $goods->c_title; ?> X <?= $goods->c_count; ?> </p>
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?= $refundment->c_amount ?></td>
                            <td><?= RefundmentDoc::getWay($refundment->c_way) ?></td>
                            <td><?= RefundmentDoc::getStatus($refundment->c_status) ?></td>
                            <td><?= date('Y-m-d H:i:s', $refundment->c_create_time) ?></td>
                            <td><?= $refundment->c_content ?></td>
                            <td><?= $refundment->c_reply ?></td>
                            <td><?= $refundment->c_note ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div class="tab-pane" id="tab3">
        <div class="box box-primary">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>配送方式</th>
                        <th>物流公司</th>
                        <th>物流单号</th>
                        <th>收件人</th>
                        <th>配送时间</th>
                        <th>备注</th>
                    </tr>
                </thead>
                <?php
                if ($model->deliveryDoc) {
                    foreach ($model->deliveryDoc as $delivery) {
                        ?>
                        <tr>
                            <td><?= isset($delivery->delivery->c_title) ? $delivery->delivery->c_title : '--' ?></td>
                            <td><?= isset($delivery->freightCompany->c_title) ? $delivery->freightCompany->c_title : '--' ?></td>
                            <td><?= $delivery->c_delivery_code ?></td>
                            <td><?= $delivery->c_full_name ?></td>
                            <td><?= date('Y-m-d H:i:s', $delivery->c_create_time) ?></td>
                            <td><?= $delivery->c_note ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div class="tab-pane" id="tab4">
        <div class="box box-primary">
            <div class="box-body">
                <?php if (CheckRule::checkRole('order/note')) { ?>
                    <?php Pjax::begin(); ?> 
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'c_user_note')->textArea(['maxlength' => true, 'rows' => 3, 'disabled' => 'disabled']) ?>
                    <?= $form->field($model, 'c_admin_note')->textArea(['maxlength' => true, 'rows' => 3]) ?>
                    <?= Html::submitButton('编辑', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab5">
        <div class="box box-primary">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>动作</th>
                        <th>用户名</th>
                        <th>管理员</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>备注</th>
                    </tr>
                </thead>
                <?php
                if ($model->orderLog) {
                    foreach ($model->orderLog as $log) {
                        ?>
                        <tr>
                            <td><?= OrderLog::getActionType($log->c_action_type) ?></td>
                            <td><?= $log->c_user_name ?></td>
                            <td><?= $log->c_admin_name ?></td>
                            <td><?= Util::getStatusText($log->c_status) ?></td>
                            <td><?= date('Y-m-d H:i:s', $log->c_create_time) ?></td>
                            <td><?= $log->c_note ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>

<div id="orderPay" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">订单支付</h4>
            </div>
            <?php
            $form = ActiveForm::begin(['action' => Url::to(['order/pay', 'id' => $model->c_id])]);
            ?>
            <div class="modal-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'c_order_no',
                        'c_order_amount',
                        ['label' => $model->getAttributeLabel('c_delivery_id'), 'format' => 'raw', 'value' => isset($model->delivery->c_title) ? $model->delivery->c_title : '--'],
                        'c_user_name',
                        'c_full_name',
                        'c_mobile',
                        ['label' => $model->getAttributeLabel('c_is_invoice'), 'format' => 'raw', 'value' => Order::getInvoiceStatus($model->c_is_invoice) . ($model->c_is_invoice == Order::STATUS_YES ? '【' . $model->c_invoice_title . '】' : '')],
                        'c_user_note',
                    ],
                ]);
                $model_collection_doc = new CollectionDoc();
                ?>
                <?= $form->field($model_collection_doc, 'c_payment_id')->dropDownList(Payment::getPaymentByAdmin(isset($model->delivery->c_type) ? $model->delivery->c_type : 0), ['value' => $model->c_payment_id]) ?>
                <?= $form->field($model_collection_doc, 'c_note')->textArea(['maxlength' => true, 'rows' => 3]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <?= Html::submitButton('支付', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>