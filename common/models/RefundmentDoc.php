<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%refundment_doc}}".
 *
 * @property string $c_id
 * @property string $c_order_no
 * @property string $c_admin_name
 * @property string $c_user_name
 * @property string $c_note
 * @property string $c_reply
 * @property string $c_content
 * @property string $c_order_goods_id
 * @property string $c_amount
 * @property integer $c_status
 * @property integer $c_way
 * @property integer $c_type
 * @property string $c_order_id
 * @property string $c_admin_id
 * @property string $c_user_id
 * @property string $c_dispose_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class RefundmentDoc extends _CommonModel {

    public $order_goods_id;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%refundment_doc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_amount'], 'number'],
            ['c_amount', 'default', 'value' => 0],
            [['c_status', 'c_way', 'c_type', 'c_order_id', 'c_admin_id', 'c_user_id', 'c_dispose_time', 'c_create_time'], 'integer'],
            [['c_update_time', 'order_goods_id'], 'safe'],
            [['c_order_no', 'c_admin_name', 'c_user_name'], 'string', 'max' => 20],
            [['c_note', 'c_reply', 'c_content', 'c_order_goods_id'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '退款单ID',
            'c_order_no' => '订单号',
            'c_admin_name' => '管理员用户名',
            'c_user_name' => '用户名',
            'c_note' => '管理员备注',
            'c_reply' => '处理意见',
            'c_content' => '申请退款原因',
            'c_order_goods_id' => '订单与商品关联ID集合',
            'c_amount' => '退款金额',
            'c_status' => '退款状态', // 1退款成功 2申请退款 3退款失败
            'c_way' => '退款流向', // 1用户余额 2其他方式
            'c_type' => '退款计算方式', // 1用户余额 2其他方式
            'c_order_id' => '订单ID',
            'c_admin_id' => '管理员ID',
            'c_user_id' => '用户ID',
            'c_dispose_time' => '处理时间',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getOrder() {
        return $this->hasOne(Order::className(), ['c_id' => 'c_order_id']);
    }

    public static function getStatus($type = null) {
        $array = [1 => '退款成功', 2 => '申请退款', 3 => '退款失败'];
        return Util::getStatusText($type, $array);
    }

    public static function getWay($type = null) {
        $array = [1 => '用户在线账户', 2 => '其他方式'];
        return Util::getStatusText($type, $array);
    }

    public static function getType($type = null) {
        $array = [1 => '系统计算', 2 => '手动输入'];
        return Util::getStatusText($type, $array);
    }

    //创建退款单
    public static function create($order_id, $create_type = self::CREATE_ADMIN) {
        $order = Order::findOne($order_id);
        if (empty($order)) {
            return '订单不存在';
        }
        $order_status = Order::getDiyOrderStatus($order_id, $order->c_order_status, $order->c_distribution_status, $order->c_payment_id);
        if (!in_array($order_status, [4, 6, 9, 10])) {
            return '订单状态非法，订单退款失败';
        }
        if (empty($order->c_user_id)) {
            return '用户为游客不支持退款';
        }
        $transaction = Yii::$app->db->beginTransaction();
        $model = new RefundmentDoc();
        if ($model->load(Yii::$app->request->post())) {
            try {
                if (empty($model->order_goods_id)) {
                    return '请选择退款商品';
                }
                //已退款商品的金额和数量
                $refunded_count = OrderGoods::find()->where(['c_order_id' => $order_id, 'c_is_send' => OrderGoods::STATUS_REFUND])->count();
                $refunded_amount = RefundmentDoc::find()->where(['c_order_id' => $order_id, 'c_status' => self::STATUS_YES])->sum('c_amount'); //已退款金额
                $refund_point = $refund_exp = 0; //积分和经验值退还
                //本次退款商品的金额和数量
                $refund_amount = 0; //本次退款金额
                $refund_count = count($model->order_goods_id); //本次退款商品数量
                //退款的商品保存
                foreach ($model->order_goods_id as $goods_id) {
                    $model_goods = OrderGoods::findOne($goods_id);
                    if ($model_goods->c_is_send == OrderGoods::STATUS_REFUND) {
                        $message = '操作非法已记录，退款商品状态已退款';
                        SystemLog::add($message);
                        return $message;
                    }
                    $model_goods->c_is_send = OrderGoods::STATUS_REFUND;
                    $result_order_goods = $model_goods->save();
                    if (!$result_order_goods) {
                        $transaction->rollback();
                        $message = '更新订单商品状态失败';
                        SystemLog::add($message);
                        return $message;
                    }
                    $refund_point += $model_goods->c_point * $model_goods->c_count;
                    $refund_exp += $model_goods->c_exp * $model_goods->c_count;
                    $refund_amount += $model_goods->c_real_price * $model_goods->c_count;
                }
                //积分和经验值退还
                if ($model_goods->c_point || $model_goods->c_exp) {
                    $result_user = UserAcount::subPoint($order->c_user_id, UserPointLog::ACOUNT_USER_REFUNDMENT, $create_type, ['order_id' => $order_id, 'order_no' => $order->c_order_no, 'point' => $refund_point, 'exp' => $refund_exp]);
                    if (empty($result_user)) {
                        $transaction->rollback();
                        $message = '退还积分失败';
                        SystemLog::add($message);
                        return $message;
                    }
                }
                //退款库存增加
                $result_goods = Order::addStoreCount($order_id, ['c_id' => $model->order_goods_id]);
                if (empty($result_goods)) {
                    $transaction->rollback();
                    $message = '退款更新商品库存失败';
                    SystemLog::add($message);
                    return $message;
                }
                //退款单保存
                if ($model->c_type == 1) {//系统计算退款金额
                    $count = OrderGoods::find()->where(['c_order_id' => $order_id, 'c_delivery_doc_id' => 0])->count(); //未发货的数量 只判断有没有发过货 以便扣除运费等
                    if ($count == $order->c_order_count) {//订单从未发货
                        if ($order->c_order_count == $refund_count) {//全部商品退款
                            $model->c_amount = $order->c_order_amount; //商品订单总金额
                        } elseif ($order->c_order_count > ($refunded_count + $refund_count)) {//部分商品退款
                            $model->c_amount = $refund_amount;
                        } elseif ($order->c_order_count == ($refunded_count + $refund_count)) {//剩下未退款的商品本次全部退款
                            $model->c_amount = $order->c_order_amount - $refunded_amount; //本次会把快递费等退还
                        } else {
                            $transaction->rollback();
                            $message = '订单ID' . $order_id . '异常，已退款金额：' . $refunded_amount . '，已退款商品数量：' . $refunded_count . '，本次退款金额：' . $refund_amount . '，本次退款商品数量：' . $refund_count;
                            SystemLog::add($message);
                            return $message;
                        }
                    } else {//有发货 不退其他费用
                        $model->c_amount = $refund_amount;
                    }
                } else {
                    if ($model->c_amount < 0) {
                        $transaction->rollback();
                        return '手动退款金额必须大于等于0';
                    }
                    if ($order->c_order_count == $refund_count) {
                        if ($model->c_amount > $order->c_order_amount) {
                            $transaction->rollback();
                            return '手动退款，金额必须小于订单总金额';
                        }
                    } else {
                        if ($model->c_amount > $refund_amount) {
                            $transaction->rollback();
                            return '手动退款，金额必须小于等于退款商品金额';
                        }
                    }
                }
                $model->c_order_id = $order_id;
                $model->c_user_id = $order->c_user_id;
                $model->c_order_no = $order->c_order_no;
                $model->c_status = self::STATUS_YES;
                $model->c_order_goods_id = implode(',', $model->order_goods_id);
                $model->c_admin_id = Yii::$app->user->identity->c_id;
                $model->c_admin_name = Yii::$app->user->identity->c_admin_name;
                $model->c_create_time = time();
                $result = $model->save();
                //订单保存
                $order->c_refundment_time = $model->c_create_time; //退款时间
                $order->c_refundment_amount = $refunded_amount + $refund_amount; //退款金额
                $order_status = Order::STATUS_REBATE;
                if (($refunded_amount && ($refunded_amount + $model->c_amount) == $order->c_order_amount) || ($refunded_amount == null && $model->c_amount == $order->c_order_amount)) {
                    $order_status = Order::STATUS_REFUNDMENT;
                }
                $order->c_order_status = $order_status;
                $result_order = $order->save(false);
                //退款
                $result_user_acount = true;
                if ($model->c_way == 1) {
                    if (UserAcount::addCash($model->c_user_id, UserAcountLog::ACOUNT_USER_REFUNDMENT, $create_type, ['order_id' => $order_id, 'order_no' => $order->c_order_no, 'amount_money' => $model->c_amount]) !== true) {
                        $result_user_acount = false;
                    }
                }
                //订单日志
                $result_log = OrderLog::add([
                            'c_order_id' => $model->c_order_id,
                            'c_status' => self::STATUS_YES,
                            'c_action_type' => OrderLog::STATUS_REFUNDMENT,
                            'c_order_no' => $model->c_order_no,
                            'c_note' => OrderLog::getActionType(OrderLog::STATUS_REFUNDMENT) . $model->c_amount . '元',
                            'c_create_time' => $model->c_create_time
                                ], $create_type);

                if ($result && $result_order && $result_user_acount && $result_log) {
                    $transaction->commit();
                    return true;
                } else {
                    $transaction->rollback();
                    return self::checkModel($model);
                }
            } catch (\Exception $e) {
                $transaction->rollback();
                self::systemLog($e);
                return $e->getMessage();
            }
        }
        return '加载数据失败';
    }

}
