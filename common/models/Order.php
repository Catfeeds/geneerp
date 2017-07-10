<?php

namespace common\models;

use Yii;
use common\extensions\Util;
use common\extensions\String;
use common\extensions\ShopCart;
use common\extensions\GoodsCart;

/**
 * This is the model class for table "t_order".
 *
 * @property string $c_id
 * @property string $c_postcode
 * @property string $c_mobile
 * @property string $c_order_no
 * @property string $c_phone
 * @property string $c_user_name
 * @property string $c_full_name
 * @property string $c_address
 * @property string $c_invoice_title
 * @property string $c_trade_no
 * @property string $c_check_code
 * @property string $c_user_note
 * @property string $c_admin_note
 * @property string $c_card_amount
 * @property string $c_payable_goods_amount
 * @property string $c_paid_goods_amount
 * @property string $c_payable_freight_amount
 * @property string $c_paid_freight_amount
 * @property string $c_insured_amount
 * @property string $c_pay_fee_amount
 * @property string $c_tax_amount
 * @property string $c_promotion_amount
 * @property string $c_admin_discount_amount
 * @property string $c_payable_order_amount
 * @property string $c_order_amount
 * @property string $c_refundment_amount
 * @property integer $c_delivery_amount_type
 * @property integer $c_comment_status
 * @property integer $c_order_status
 * @property integer $c_pay_status
 * @property integer $c_point_status
 * @property integer $c_distribution_status
 * @property integer $c_order_type
 * @property integer $c_create_type
 * @property integer $c_is_checkout
 * @property integer $c_is_invoice
 * @property integer $c_accept_time
 * @property string $c_user_id
 * @property string $c_weight
 * @property string $c_payment_id
 * @property string $c_delivery_id
 * @property string $c_card_id
 * @property string $c_province_id
 * @property string $c_city_id
 * @property string $c_area_id
 * @property string $c_order_count
 * @property string $c_order_weight
 * @property string $c_exp
 * @property string $c_point
 * @property string $c_takeself_id
 * @property string $c_active_id
 * @property string $c_union_id
 * @property string $c_point_time
 * @property string $c_refundment_time
 * @property string $c_cancel_time
 * @property string $c_comment_time
 * @property string $c_finish_time
 * @property string $c_send_time
 * @property string $c_pay_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Order extends _CommonModel {

    //订单状态
    const STATUS_WAIT_PAY = 1; //等待用户付款
    const STATUS_ALREADY_PAY = 2; //用户已付款
    const STATUS_USER_CANCEL = 3; //用户取消订单
    const STATUS_ADMIN_CANCEL = 4; //平台取消订单
    const STATUS_FINISH = 5; //订单完成
    const STATUS_REFUNDMENT = 6; //全额退款成功
    const STATUS_REBATE = 7; //部分退款成功
    //发货状态
    const DISTRIBUTION_YES = 1; //已发货
    const DISTRIBUTION_NO = 2; //未发货
    const DISTRIBUTION_PART = 3; //部分发货

    public $goods_count; //购物车商品数量
    private $order_goods;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_postcode', 'c_mobile', 'c_phone', 'c_full_name', 'c_user_note', 'c_admin_note', 'c_address', 'c_invoice_title'], 'filter', 'filter' => 'trim'],
            [['c_delivery_id', 'c_delivery_amount_type', 'c_admin_discount_amount', 'c_accept_time', 'c_is_invoice', 'c_province_id', 'c_city_id', 'c_full_name', 'c_mobile'], 'required'],
            [['c_area_id'], 'default', 'value' => 0],
            [['c_card_amount', 'c_payable_goods_amount', 'c_paid_goods_amount', 'c_payable_freight_amount', 'c_paid_freight_amount', 'c_insured_amount', 'c_pay_fee_amount', 'c_tax_amount', 'c_promotion_amount', 'c_admin_discount_amount', 'c_payable_order_amount', 'c_order_amount', 'c_refundment_amount'], 'number'],
            [['c_delivery_amount_type', 'c_comment_status', 'c_order_status', 'c_pay_status', 'c_point_status', 'c_distribution_status', 'c_order_type', 'c_create_type', 'c_is_checkout', 'c_is_invoice', 'c_accept_time', 'c_user_id', 'c_weight', 'c_payment_id', 'c_delivery_id', 'c_card_id', 'c_province_id', 'c_city_id', 'c_area_id', 'c_order_count', 'c_order_weight', 'c_exp', 'c_point', 'c_takeself_id', 'c_active_id', 'c_union_id', 'c_point_time', 'c_refundment_time', 'c_cancel_time', 'c_comment_time', 'c_finish_time', 'c_send_time', 'c_pay_time', 'c_create_time'], 'integer'],
            [['c_update_time', 'goods_count'], 'safe'],
            [['c_postcode'], 'string', 'max' => 6],
            [['c_mobile'], 'string', 'max' => 11],
            [['c_order_no', 'c_phone', 'c_user_name', 'c_full_name'], 'string', 'max' => 20],
            [['c_address', 'c_invoice_title'], 'string', 'max' => 100],
            [['c_trade_no', 'c_check_code'], 'string', 'max' => 255],
            [['c_user_note', 'c_admin_note'], 'string', 'max' => 1000],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['goods_id', 'goods_count', 'c_postcode', 'c_mobile', 'c_order_no', 'c_phone', 'c_user_name', 'c_full_name', 'c_address', 'c_invoice_title', 'c_check_code', 'c_user_note', 'c_admin_note', 'c_card_amount', 'c_payable_goods_amount', 'c_paid_goods_amount', 'c_payable_freight_amount', 'c_paid_freight_amount', 'c_insured_amount', 'c_pay_fee_amount', 'c_tax_amount', 'c_promotion_amount', 'c_admin_discount_amount', 'c_payable_order_amount', 'c_order_amount', 'c_refundment_amount', 'c_delivery_amount_type', 'c_order_status', 'c_pay_status', 'c_order_type', 'c_create_type', 'c_is_invoice', 'c_accept_time', 'c_user_id', 'c_payment_id', 'c_delivery_id', 'c_card_id', 'c_province_id', 'c_city_id', 'c_area_id', 'c_order_count', 'c_order_weight', 'c_exp', 'c_point', 'c_takeself_id', 'c_active_id', 'c_union_id', 'c_create_time'];
        $scenarios['update'] = ['goods_id', 'goods_count', 'c_postcode', 'c_mobile', 'c_phone', 'c_full_name', 'c_address', 'c_invoice_title', 'c_check_code', 'c_user_note', 'c_admin_note', 'c_payable_goods_amount', 'c_paid_goods_amount', 'c_payable_freight_amount', 'c_paid_freight_amount', 'c_insured_amount', 'c_pay_fee_amount', 'c_tax_amount', 'c_promotion_amount', 'c_admin_discount_amount', 'c_payable_order_amount', 'c_order_amount', 'c_refundment_amount', 'c_delivery_amount_type', 'c_order_status', 'c_pay_status', 'c_order_type', 'c_create_type', 'c_is_invoice', 'c_accept_time', 'c_payment_id', 'c_delivery_id', 'c_province_id', 'c_city_id', 'c_area_id', 'c_order_count', 'c_order_weight', 'c_exp', 'c_point', 'c_takeself_id'];
        $scenarios['note'] = ['c_admin_note'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_postcode' => '邮政编码',
            'c_mobile' => '收货人手机',
            'c_order_no' => '订单号',
            'c_phone' => '收货人电话',
            'c_user_name' => '用户名',
            'c_full_name' => '收货人姓名',
            'c_address' => '收货地址',
            'c_invoice_title' => '发票抬头',
            'c_trade_no' => '支付平台交易号',
            'c_check_code' => '自提方式的验证码',
            'c_user_note' => '用户附言',
            'c_admin_note' => '管理员备注',
            'c_card_amount' => '代金券面值',
            'c_payable_goods_amount' => '应付商品总金额',
            'c_paid_goods_amount' => '实付商品总金额',
            'c_payable_freight_amount' => '应付运费',
            'c_paid_freight_amount' => '实付运费',
            'c_insured_amount' => '保价金额',
            'c_pay_fee_amount' => '支付手续费',
            'c_tax_amount' => '税金',
            'c_promotion_amount' => '促销优惠金额',
            'c_admin_discount_amount' => '平台增减金额', // 例如 折扣 去零头 减去金额加上负号
            'c_payable_order_amount' => '应付订单总金额',
            'c_order_amount' => '实付订单总金额',
            'c_refundment_amount' => '退款金额',
            'c_delivery_amount_type' => '配送费用计算方式', // 1配送方式系统计算 2手工输入
            'c_comment_status' => '是否评论 1已评论 2未评论',
            'c_order_status' => '订单状态',
            'c_pay_status' => '支付状态', // 1已支付 2待支付
            'c_point_status' => '积分状态', // 1已发放 2未发放 3已退还
            'c_distribution_status' => '配送状态', // 1已发货 2未发货 3部分发货
            'c_order_type' => '订单类型', // 1普通订单 2团购订单 3限时抢购
            'c_create_type' => '来源类型 1PC 2H5 3IOS 4Andriod 8其他 9平台',
            'c_is_checkout' => '营销联盟结算状态 1已结算 2未结算',
            'c_is_invoice' => '发票', // 1索要 2不索要
            'c_accept_time' => '用户收货时间段',
            'c_user_id' => '用户ID',
            'c_weight' => '订单商品总重量',
            'c_payment_id' => '支付方式', //默认0货到付款
            'c_delivery_id' => '配送方式',
            'c_card_id' => '代金券ID',
            'c_province_id' => '省份',
            'c_city_id' => '市级',
            'c_area_id' => '地区',
            'c_order_count' => '订单商品种类数量',
            'c_order_weight' => '订单商品总重量',
            'c_exp' => '订单可获取的经验值',
            'c_point' => '订单可获取的积分',
            'c_takeself_id' => '自提点ID',
            'c_active_id' => '促销活动ID',
            'c_union_id' => '营销联盟ID',
            'c_point_time' => '积分最后变动时间',
            'c_refundment_time' => '退款时间',
            'c_cancel_time' => '取消时间',
            'c_comment_time' => '评论时间',
            'c_finish_time' => '完成时间',
            'c_send_time' => '发货时间',
            'c_pay_time' => '付款时间',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getOrderGoods() {
        return $this->hasMany(OrderGoods::className(), ['c_order_id' => 'c_id']);
    }

    public function getPayment() {
        return $this->hasOne(Payment::className(), ['c_id' => 'c_payment_id']);
    }

    public function getDelivery() {
        return $this->hasOne(Delivery::className(), ['c_id' => 'c_delivery_id']);
    }

    public function getCollectionDoc() {
        return $this->hasOne(CollectionDoc::className(), ['c_order_id' => 'c_id']);
    }

    public function getDeliveryDoc() {
        return $this->hasMany(DeliveryDoc::className(), ['c_order_id' => 'c_id']);
    }

    public function getRefundmentDoc() {
        return $this->hasMany(RefundmentDoc::className(), ['c_order_id' => 'c_id']);
    }

    public function getOrderLog() {
        return $this->hasMany(OrderLog::className(), ['c_order_id' => 'c_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['c_id' => 'c_user_id']);
    }

    public static function getExportField() {
        return [
            'c_order_no' => '订单号',
            'c_mobile' => '手机',
            'c_phone' => '联系电话',
            'c_user_name' => '用户名',
            'c_full_name' => '收货人姓名',
            'c_address' => '收货地址',
            'c_invoice_title' => '发票抬头',
            'c_user_note' => '用户附言',
            'c_admin_note' => '管理员备注',
            'c_payable_order_amount' => '应付订单总金额',
            'c_order_amount' => '实付订单总金额',
            'c_order_status' => '订单状态',
            'c_pay_status' => '支付状态',
            'c_distribution_status' => '配送状态',
            'c_is_invoice' => '是否开发票',
            'c_order_type' => '订单类型',
            'c_postcode' => '邮政编码',
            'c_payment_id' => '支付方式',
            'c_delivery_id' => '配送方式',
            'c_weight' => '总重量',
            'c_refundment_time' => '退款时间',
            'c_cancel_time' => '取消时间',
            'c_finish_time' => '完成时间',
            'c_send_time' => '发货时间',
            'c_pay_time' => '付款时间',
            'c_create_time' => '创建时间',
            'orderGoods' => '商品列表'
        ];
    }

    //获取订单状态
    public static function getOrderStatusText($type = null) {
        $array = [
            self::STATUS_WAIT_PAY => '等待用户付款',
            self::STATUS_ALREADY_PAY => '用户已付款',
            self::STATUS_USER_CANCEL => '用户取消订单',
            self::STATUS_ADMIN_CANCEL => '平台取消订单',
            self::STATUS_FINISH => '订单完成',
            self::STATUS_REFUNDMENT => '全额退款成功',
            self::STATUS_REBATE => '部分退款成功'
        ];
        return Util::getStatusText($type, $array);
    }

    public static function getUserOrderStatusText() {
        return [
            1 => '待付款',
            2 => '已付款',
            3 => '已发货',
            4 => '交易成功',
            5 => '交易取消',
            6 => '退款中的订单',
            7 => '已删除',
        ];
    }

    public static function getTime($type = null) {
        $array = [1 => '近三个月提现', 2 => '近半年提现', 3 => '一年内提现'];
        return Util::getStatusText($type, $array);
    }

    public static function getPayStatus($type = null) {
        $array = [1 => '已支付', 2 => '待支付'];
        return Util::getStatusText($type, $array);
    }

    public static function getInvoiceStatus($type = null) {
        $array = [1 => '索要', 2 => '不索要'];
        return Util::getStatusText($type, $array);
    }

    public static function getOrderType($type = null) {
        $array = [1 => '普通订单', 2 => '团购订单', 3 => '限时抢购'];
        return Util::getStatusText($type, $array);
    }

    public static function getCheckoutStatus($type = null) {
        $array = [1 => '已结算', 2 => '未结算'];
        return Util::getStatusText($type, $array);
    }

    public static function getDeliveryAmountType($type = null) {
        $array = [1 => '配送费用系统计算', 2 => '手工输入费用'];
        return Util::getStatusText($type, $array);
    }

    public static function getDistributionStatus($type = null) {
        $array = [self::DISTRIBUTION_YES => '已发货', self::DISTRIBUTION_NO => '未发货', self::DISTRIBUTION_PART => '部分发货'];
        return Util::getStatusText($type, $array);
    }

    public static function getAcceptTime($type = null) {
        $array = [1 => '任意时间段', 2 => '周一到周五', 3 => '周末'];
        return Util::getStatusText($type, $array);
    }

    /**
     * 取消订单
     * @param type $order_id
     * @param type $create_type
     * @return boolean
     */
    public static function cancel($order_id, $create_type = self::CREATE_ADMIN) {
        $order = Order::findOne($order_id);
        if (empty($order)) {
            return '订单不存在';
        }
        $order_status = Order::getDiyOrderStatus($order_id, $order->c_order_status, $order->c_distribution_status, $order->c_payment_id);
        if (!in_array($order_status, [1, 2])) {//用户取消订单
            return '订单状态非法，订单取消失败';
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $order->c_order_status = $create_type == self::CREATE_ADMIN ? self::STATUS_ADMIN_CANCEL : self::STATUS_USER_CANCEL;
            $order->c_cancel_time = time();
            $result = $order->save(false);
            $result_goods = Order::addStoreCount($order_id);
            $result_card = true;
            //还原代金券可使用
            if ($order->c_card_id) {
                $result_model = MarketCard::find()->where(['c_id' => $order->c_card_id, 'c_status' => self::STATUS_YES, 'c_is_send' => self::STATUS_YES, 'c_is_used' => self::STATUS_YES])->one();
                if ($result_model) {
                    $result_model->c_is_used = self::STATUS_NO;
                    $result_card = $result_model->save();
                }
            }
            //订单日志
            $result_order_log = OrderLog::add([
                        'c_order_id' => $order_id,
                        'c_status' => self::STATUS_YES,
                        'c_action_type' => OrderLog::STATUS_CANCEL,
                        'c_order_no' => $order->c_order_no,
                        'c_create_time' => $order->c_cancel_time
                            ], $create_type);
            if ($result && $result_goods && $result_card && $result_order_log) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return self::checkModel($order);
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            self::systemLog($e);
            return $e->getMessage();
        }
    }

    /**
     * 完成订单
     * @param type $order_id
     * @param type $create_type
     * @return boolean
     */
    public static function finish($order_id, $create_type = self::CREATE_ADMIN) {
        $order = Order::findOne($order_id);
        if (empty($order)) {
            return '订单不存在';
        }
        $order_status = Order::getDiyOrderStatus($order_id, $order->c_order_status, $order->c_distribution_status, $order->c_payment_id);
        if (!in_array($order_status, [3, 11])) {
            return '订单状态非法，订单确认失败';
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($order->c_user_id && $order->c_pay_status == self::STATUS_YES) {
                $point_exp = OrderGoods::findPointExp($order_id);
                if ($point_exp[0] || $point_exp[1]) {
                    $result_user = UserAcount::addPoint($order->c_user_id, UserPointLog::ACOUNT_USER_ORDER_SUCCESS, $create_type, ['order_id' => $order_id, 'order_no' => $order->c_order_no, 'point' => $point_exp[0], 'exp' => $point_exp[1]]);
                    if ($result_user !== true) {
                        $transaction->rollback();
                        return $result_user;
                    }
                }
                $order->c_point_status = OrderGoods::STATUS_SEND_YES;
                $order->c_point_time = time();
            }
            $order->c_order_status = self::STATUS_FINISH;
            $order->c_finish_time = time();
            $result = $order->save(false);
            //订单日志
            $result_order_log = OrderLog::add([
                        'c_order_id' => $order_id,
                        'c_status' => self::STATUS_YES,
                        'c_action_type' => OrderLog::STATUS_FINISH,
                        'c_order_no' => $order->c_order_no,
                        'c_create_time' => $order->c_finish_time
                            ], $create_type);
            if ($result && $result_order_log) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return self::checkModel($order);
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            self::systemLog($e);
            return $e->getMessage();
        }
    }

    //创建订单单号
    public static function createOrderNumber($user_id = 0) {
        if (empty($user_id)) {
            $user_id = '000000'; //游客
        }
        $len = strlen($user_id);
        if ($len > 6) {
            $user_id = substr($user_id, -6);
        } elseif ($len < 6) {
            $user_id = str_repeat(0, 6 - $len) . $user_id; //不够4位前面补0
        }
        $number = date('YmdH') . mt_rand(1000, 9999) . $user_id; //随机生成16位编号
        if (Order::findOne(['c_order_no' => $number])) {
            return self::createOrderNumber($user_id);
        }
        return $number;
    }

    //减少库存
    public static function subtractStoreCount($order_id, $where = []) {
        if (Yii::$app->params['store_status'] === '1') {
            $where['c_order_id'] = $order_id;
            $data = OrderGoods::find()->where($where)->all();
            if ($data) {
                foreach ($data as $model) {
                    $model->goods->c_store_count -= $model->c_count;
                    if (empty($model->goods->save(false))) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    //增加库存
    public static function addStoreCount($order_id, $where = []) {
        if (Yii::$app->params['store_status'] === '1') {
            $where['c_order_id'] = $order_id;
            $data = OrderGoods::find()->where($where)->all();
            if ($data) {
                foreach ($data as $model) {
                    $model->goods->c_store_count += $model->c_count;
                    if (empty($model->goods->save(false))) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * 获取订单状态
     * @param type $order_id 订单自增ID
     * @param type $order_status 订单状态
     * @param type $distribution_status 发货状态
     * @param type $payment_id 支付类型 0为货到付款
     * @return int
     */
    public static function getDiyOrderStatus($order_id, $order_status, $distribution_status, $payment_id) {
        //1 等待用户付款
        if ($order_status == self::STATUS_WAIT_PAY) {
            if ($payment_id == 0) {//0货到付款
                if ($distribution_status == self::DISTRIBUTION_NO) {//2未发货
                    return 1; //未付款等待发货(货到付款)
                } else if ($distribution_status == self::DISTRIBUTION_YES) {//1已发货
                    return 11; //已发货(货到付款)
                } else if ($distribution_status == self::DISTRIBUTION_PART) {//3部分发送
                    return 8; //部分发货(货到付款+已经付款)
                }
            } else {
                return 2; //等待付款(线上支付)
            }
        }
        //2 用户已付款
        else if ($order_status == self::STATUS_ALREADY_PAY) {
            $refundment = RefundmentDoc::findOne(['c_order_id' => $order_id, 'c_status' => self::STATUS_NO]); //申请退款
            if ($refundment) {
                return 12; //未处理的退款申请
            }
            if ($distribution_status == self::DISTRIBUTION_NO) {//2未发送
                return 4; //已付款待发货
            } else if ($distribution_status == self::DISTRIBUTION_YES) {//1已发送 
                return 3; //已发货(已付款)
            } else if ($distribution_status == self::DISTRIBUTION_PART) {//3部分发送
                return 8; //部分发货(货到付款+已经付款)
            }
        }
        //3 用户取消或者平台取消订单
        else if ($order_status == self::STATUS_USER_CANCEL || $order_status == self::STATUS_ADMIN_CANCEL) {
            return 5;
        }
        //4 完成订单
        else if ($order_status == self::STATUS_FINISH) {
            return 6; //已完成(已付款,已收货)
        }
        //5 全额退款成功
        else if ($order_status == self::STATUS_REFUNDMENT) {
            return 7;
        }
        //6 部分退款成功
        else if ($order_status == self::STATUS_REBATE) {
            if ($distribution_status == self::DISTRIBUTION_YES) {
                return 10; //部分退款(全部发货)
            } else {
                return 9; //部分退款(未发货+部分发货)
            }
        }
        return 0;
    }

    public static function getDiyOrderStatusText($order_id, $order_status, $distribution_status, $payment_id) {
        $status = self::getDiyOrderStatus($order_id, $order_status, $distribution_status, $payment_id);
        return self::_getDiyorderStatusText($status);
    }

    /**
     * 获取订单状态说明
     * @param $type int 订单的状态码
     * @return string 订单状态说明
     */
    private static function _getDiyorderStatusText($type = null) {
        $array = array(
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
        );
        return Util::getStatusText($type, $array);
    }

    //获取订单支付状态
    public static function getOrderPayStatusText($order_status, $pay_status) {
        if ($order_status == self::STATUS_REFUNDMENT) {
            return '全部退款';
        }

        if ($order_status == self::STATUS_REBATE) {
            return '部分退款';
        }

        if ($pay_status == self::STATUS_NO) {
            return '未付款';
        }

        if ($pay_status == self::STATUS_YES) {
            return '已付款';
        }
        return '未知';
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (in_array($this->scenario, ['create', 'update'])) {
                $goods_count = $this->goods_count;
                if (empty($goods_count)) {
                    $this->addError('goods_count', '请选择商品再创建订单');
                    return false;
                }
                //创建订单判断商品库存
                $goods_list = Goods::findId(['c_id' => array_keys($goods_count)]);
                $cart = GoodsCart::getCart();
                if ($this->isNewRecord) {
                    foreach ($goods_list as $model) {
                        //新增时 临时保存购物车的商品 在出错的情况下保留购物商品数据 创建订单成功后会清空
                        $cart->addItem($model->c_id, $model->c_title, $model->c_sell_price, Upload::getThumbOne($model->c_picture, false), (int) $goods_count[$model->c_id], false);
                    }
                }
                foreach ($goods_list as $model) {
                    $count = (int) $goods_count[$model->c_id];
                    if (Yii::$app->params['store_status'] === '1') {
                        if ($model->c_store_count == 0) {
                            $this->addError('goods_count', '商品：' . $model->c_title . '，没有库存。');
                            return false;
                        }
                        if ($count == 0) {
                            $this->addError('goods_count', '商品：' . $model->c_title . '，购买数量不能为空。');
                            return false;
                        }
                        if ($this->isNewRecord) {
                            if ($goods_count[$model->c_id] > $model->c_store_count) {
                                $this->addError('goods_count', '商品：' . $model->c_title . ' 购买数量超出库存' . $model->c_store_count . $model->c_unit . '，请重新调整购买数量。');
                                return false;
                            }
                        } else {
                            $order_goods_model = OrderGoods::findOne(['c_goods_id' => $model->c_id, 'c_order_id' => $this->c_id]);
                            if ($order_goods_model) {
                                $all_count = $model->c_store_count + $order_goods_model->c_count;
                                if ($count > $all_count) {
                                    $this->addError('goods_count', '商品：' . $model->c_title . ' 购买数量超出库存' . $all_count . $model->c_unit . '，请重新调整购买数量。');
                                    return false;
                                }
                            }
                        }
                    }
                }

                if (empty($this->c_delivery_id)) {
                    $this->addError('c_delivery_id', '请选择配送方式');
                    return false;
                }
                $delivery = Delivery::findOne($this->c_delivery_id);
                if (empty($delivery)) {
                    $this->addError('c_delivery_id', '配送方式不存在');
                    return false;
                }
                if ($delivery->c_status == self::STATUS_NO) {
                    $this->addError('c_delivery_id', '配送方式状态无效');
                    return false;
                }
                if ($insert) {
                    //判断用户名
                    if ($this->c_create_type == self::CREATE_ADMIN) {
                        if ($this->c_user_name) {
                            $user = User::existUsername($this->c_user_name);
                            if ($user) {
                                $this->c_user_id = $user->c_id; //购买商品的用户ID
                            } else {
                                $this->addError('c_user_name', '所属用户名【' . $this->c_user_name . '】不存在');
                                return false;
                            }
                        } else {
                            $this->c_user_id = 0; //初始化为游客
                        }
                    } else {
                        $this->c_user_id = Yii::$app->user->getId();
                    }
                    $this->c_order_no = self::createOrderNumber($this->c_user_id); //订单编号
                    $this->c_order_status = self::STATUS_WAIT_PAY; //设置待支付
                }

                $this->c_payment_id = 1; //默认支付采用现金账户金额支付
                if ($delivery->c_type == 3) {//自提点需要提取码验证
                    $this->c_check_code = String::randString(6, 1); //6位数字
                } elseif ($delivery->c_type == 2) {
                    $this->c_payment_id = 0; //线下支付
                }

                $shop_cart = new ShopCart();
                $shop_cart->init($this->c_user_id);
                $shop_cart->dataFormat($this->goods_count);
                if ((int) $this->c_delivery_amount_type == 1) {
                    $this->c_paid_freight_amount = 0;
                }
                $shop_cart->checkOut($this->c_province_id, $this->c_delivery_id, $this->c_payment_id, $this->c_is_invoice, $this->c_paid_freight_amount, $this->c_admin_discount_amount);
                if ($shop_cart->error) {
                    $this->addError('goods_count', $shop_cart->error);
                    return false;
                } else {
                    $data = $shop_cart->order_data;
                    $this->c_payable_goods_amount = $data['payable_goods_amount']; //应付商品总金额
                    $this->c_paid_goods_amount = $data['paid_goods_amount']; //实付商品总金额
                    $this->c_payable_freight_amount = $data['payable_freight_amount']; //应付运费
                    $this->c_paid_freight_amount = $data['paid_freight_amount']; //实付运费
                    $this->c_insured_amount = $data['insured_amount']; //保价金额
                    $this->c_pay_fee_amount = $data['pay_fee_amount']; //支付手续费
                    $this->c_tax_amount = $data['tax_amount']; //税金
                    $this->c_promotion_amount = $data['promotion_amount']; //促销优惠金额
                    $this->c_payable_order_amount = $data['payable_order_amount']; //应付订单总金额
                    $this->c_order_amount = $data['order_amount']; //实付订单总金额
                    $this->c_point = $data['point']; //积分
                    $this->c_exp = $data['exp']; //经验值
                    $this->c_weight = $data['weight']; //订单总重量
                    $this->order_goods = $data['order_goods'];
                    $this->c_order_count = $data['order_count'];
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 保存之后处理相关数据
     * @param type $insert
     * @param type $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if (in_array($this->scenario, ['create', 'update'])) {
            $cart = GoodsCart::getCart(); //清空上次临时购物车的商品
            $cart->clearCart();
            OrderGoods::add($this->order_goods, $this->c_id, $this->c_order_no);
            if ($this->scenario == 'create') {
                OrderLog::add(['c_order_id' => $this->c_id, 'c_status' => self::STATUS_YES, 'c_action_type' => OrderLog::STATUS_CREATE, 'c_order_no' => $this->c_order_no, 'c_create_time' => $this->c_create_time], $this->c_create_type);
            }
        }
    }

}
