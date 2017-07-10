<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%collection_doc}}".
 *
 * @property string $c_id
 * @property string $c_order_no
 * @property string $c_admin_name
 * @property string $c_user_name
 * @property string $c_note
 * @property string $c_amount
 * @property integer $c_pay_status
 * @property string $c_order_id
 * @property string $c_payment_id
 * @property string $c_admin_id
 * @property string $c_user_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class CollectionDoc extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%collection_doc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_amount'], 'number'],
            [['c_payment_id'], 'required'],
            [['c_pay_status', 'c_order_id', 'c_payment_id', 'c_admin_id', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_order_no', 'c_admin_name', 'c_user_name'], 'string', 'max' => 20],
            [['c_note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '收款单ID',
            'c_order_no' => '订单号',
            'c_admin_name' => '管理员用户名',
            'c_user_name' => '用户名',
            'c_note' => '收款单备注',
            'c_amount' => '支付金额',
            'c_pay_status' => '支付状态 1已支付 2待支付',
            'c_order_id' => '订单ID',
            'c_payment_id' => '支付方式',
            'c_admin_id' => '管理员ID',
            'c_user_id' => '用户ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getPayment() {
        return $this->hasOne(Payment::className(), ['c_id' => 'c_payment_id']);
    }

    public static function create($order_id, $create_type = Order::CREATE_ADMIN) {
        $order = Order::findOne($order_id);
        if (empty($order)) {
            return '订单不存在';
        }
        $order_status = Order::getDiyOrderStatus($order_id, $order->c_order_status, $order->c_distribution_status, $order->c_payment_id);
        if (!in_array($order_status, [2, 11])) {
            return '订单状态非法，订单支付失败';
        }
        $model = new CollectionDoc();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->c_order_id = $order_id;
                $model->c_user_id = $order->c_user_id;
                $model->c_order_no = $order->c_order_no;
                $model->c_amount = $order->c_order_amount;
                //预存款扣除操作
                if ($order->c_user_id && $model->c_payment_id == 1) {//有用户名 并且选择了预存款支付需要检查预存款是否可以支付本次订单
                    $result_user_acount = UserAcount::subCash($order->c_user_id, UserAcountLog::ACOUNT_ADMIN_PAY_ORDER, $create_type, ['order_id' => $order_id, 'order_no' => $order->c_order_no, 'amount_money' => $order->c_order_amount]);
                    if ($result_user_acount !== true) {
                        $transaction->rollback();
                        return $result_user_acount;
                    }
                }
                //收款单保存
                if ($create_type == Order::CREATE_ADMIN) {
                    $model->c_admin_id = Yii::$app->user->identity->c_id;
                    $model->c_admin_name = Yii::$app->user->identity->c_admin_name;
                } else {
                    $model->c_username = Yii::$app->user->identity->c_user_name;
                }
                $model->c_create_time = time();
                $model->c_pay_status = self::STATUS_YES;
                $result = $model->save();
                //订单保存
                $order->c_payment_id = $model->c_payment_id; //支付方式
                $order->c_pay_status = self::STATUS_YES; //已支付
                $order->c_order_status = Order::STATUS_ALREADY_PAY; //已支付
                $order->c_pay_time = $model->c_create_time; //支付时间
                $result_order = $order->save();
                //订单日志
                $result_log = OrderLog::add([
                            'c_order_id' => $order_id,
                            'c_status' => self::STATUS_YES,
                            'c_action_type' => OrderLog::STATUS_PAY,
                            'c_order_no' => $order->c_order_no,
                            'c_note' => OrderLog::getActionType(OrderLog::STATUS_PAY) . $order->c_order_amount . '元',
                            'c_create_time' => $model->c_create_time
                                ], $create_type);
                if ($result && $result_order && $result_log) {
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
