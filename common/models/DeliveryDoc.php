<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%delivery_doc}}".
 *
 * @property string $c_id
 * @property string $c_mobile
 * @property string $c_phone
 * @property string $c_full_name
 * @property string $c_admin_name
 * @property string $c_address
 * @property string $c_delivery_code
 * @property string $c_note
 * @property string $c_real_freight
 * @property string $c_postcode
 * @property string $c_province_id
 * @property string $c_city_id
 * @property string $c_area_id
 * @property string $c_order_id
 * @property string $c_freight_id
 * @property string $c_delivery_id
 * @property string $c_admin_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class DeliveryDoc extends _CommonModel {

    public $order_goods_id;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%delivery_doc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_mobile', 'c_phone', 'c_full_name', 'c_address', 'c_delivery_code', 'c_note', 'c_postcode'], 'filter', 'filter' => 'trim'],
            ['c_area_id', 'default', 'value' => 0],
            /**
             * 自动生成规则
             */
            [['c_mobile', 'c_full_name', 'c_address', 'c_delivery_code', 'c_province_id', 'c_city_id', 'c_freight_id'], 'required'],
            [['c_real_freight'], 'number'],
            [['c_postcode', 'c_province_id', 'c_city_id', 'c_area_id', 'c_order_id', 'c_freight_id', 'c_delivery_id', 'c_admin_id', 'c_create_time'], 'integer'],
            [['c_update_time', 'order_goods_id'], 'safe'],
            [['c_mobile'], 'string', 'max' => 11],
            [['c_phone', 'c_full_name', 'c_admin_name'], 'string', 'max' => 20],
            [['c_address'], 'string', 'max' => 100],
            [['c_delivery_code'], 'string', 'max' => 255],
            [['c_note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '发货单ID',
            'c_mobile' => '收货人手机',
            'c_phone' => '收货人电话',
            'c_full_name' => '收货人姓名',
            'c_admin_name' => '管理员用户名',
            'c_address' => '收货地址',
            'c_delivery_code' => '物流单号',
            'c_note' => '管理员备注',
            'c_real_freight' => '实付运费',
            'c_postcode' => '邮政编码',
            'c_province_id' => '省份',
            'c_city_id' => '市级',
            'c_area_id' => '地区',
            'c_order_id' => '订单ID',
            'c_freight_id' => '货运公司',
            'c_delivery_id' => '配送方式',
            'c_admin_id' => '管理员ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getOrder() {
        return $this->hasOne(Order::className(), ['c_id' => 'c_order_id']);
    }

    public function getFreightCompany() {
        return $this->hasOne(FreightCompany::className(), ['c_id' => 'c_freight_id']);
    }

    public function getDelivery() {
        return $this->hasOne(Delivery::className(), ['c_id' => 'c_delivery_id']);
    }

    /**
     * 创建发货单
     * @param type $order_id 订单ID
     * @param type $delivery 配送方式模型
     * @return boolean|string
     */
    public static function create($order_id) {
        $order = Order::findOne($order_id);
        if (empty($order)) {
            return '订单不存在';
        }
        $order_status = Order::getDiyOrderStatus($order_id, $order->c_order_status, $order->c_distribution_status, $order->c_payment_id);
        if (!in_array($order_status, [1, 4, 8, 9])) {
            return '订单状态非法，订单发货失败';
        }
        $model = new DeliveryDoc();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (empty($model->order_goods_id)) {
                    return '请选择发货商品';
                }
                $model->c_order_id = $order_id;
                $model->c_delivery_id = $order->c_delivery_id;
                $model->c_real_freight = $order->c_paid_freight_amount;
                $model->c_admin_id = Yii::$app->user->identity->c_id;
                $model->c_admin_name = Yii::$app->user->identity->c_admin_name;
                $model->c_create_time = time();
                $result = $model->save();

                //发货的商品保存
                foreach ($model->order_goods_id as $goods_id) {
                    $model_order_goods = OrderGoods::findOne($goods_id);
                    $model_order_goods->c_delivery_doc_id = $model->c_id;
                    $model_order_goods->c_is_send = OrderGoods::STATUS_SEND_YES;
                    if (empty($model_order_goods->save())) {
                        $transaction->rollback();
                        return '更新订单商品状态失败';
                    }
                }
                //订单保存
                $count = OrderGoods::find()->where(['c_order_id' => $order_id, 'c_is_send' => OrderGoods::STATUS_SEND_YES])->count(); //有配送单ID 大于0说明已发货
                //已发货的商品种类数量+本次发货的商品种类数量 == 订单商品种类数量
                $order->c_distribution_status = $count == $order->c_order_count ? Order::DISTRIBUTION_YES : Order::DISTRIBUTION_PART; //配送状态 1已发送 2未发送 3部分发送
                $order->c_send_time = $model->c_create_time; //发货时间
                $result_order = $order->save(false);
                //订单日志
                $result_log = OrderLog::add([
                            'c_order_id' => $order_id,
                            'c_status' => self::STATUS_YES,
                            'c_action_type' => OrderLog::STATUS_DELIVERY,
                            'c_order_no' => $order->c_order_no,
                            'c_create_time' => $model->c_create_time
                ]);
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
