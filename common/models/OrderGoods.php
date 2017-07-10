<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%order_goods}}".
 *
 * @property string $c_id
 * @property string $c_order_no
 * @property string $c_number
 * @property string $c_title
 * @property string $c_picture
 * @property string $c_sell_price
 * @property string $c_real_price
 * @property integer $c_is_send
 * @property string $c_exp
 * @property string $c_point
 * @property string $c_goods_id
 * @property string $c_delivery_doc_id
 * @property string $c_union_id
 * @property string $c_count
 * @property string $c_weight
 * @property string $c_order_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class OrderGoods extends _CommonModel {

    const STATUS_SEND_YES = 1; //已发货
    const STATUS_SEND_NO = 2; //未发货
    const STATUS_REFUND = 3; //已退款

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return '{{%order_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_order_no', 'c_order_id'], 'required'],
            [['c_sell_price', 'c_real_price'], 'number'],
            [['c_is_send', 'c_exp', 'c_point', 'c_goods_id', 'c_delivery_doc_id', 'c_union_id', 'c_count', 'c_weight', 'c_order_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_order_no'], 'string', 'max' => 20],
            [['c_number'], 'string', 'max' => 50],
            [['c_title', 'c_picture'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_order_no' => '订单号',
            'c_number' => '商品货号',
            'c_title' => '商品名称',
            'c_picture' => '商品图片',
            'c_sell_price' => '商品原价',
            'c_real_price' => '实付金额',
            'c_is_send' => '发货状态', // 1已发货 2未发货 3已退款
            'c_exp' => '增加的经验',
            'c_point' => '增加的积分',
            'c_goods_id' => '商品ID',
            'c_delivery_doc_id' => '配送方式',
            'c_union_id' => '营销联盟ID',
            'c_count' => '商品数量',
            'c_weight' => '重量',
            'c_order_id' => '订单ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getGoods() {
        return $this->hasOne(Goods::className(), ['c_id' => 'c_goods_id']);
    }

    public function getDeliveryDoc() {
        return $this->hasOne(DeliveryDoc::className(), ['c_id' => 'c_delivery_doc_id']);
    }

    public static function getSendStatus($type = null) {
        $array = [self::STATUS_SEND_YES => '已发货', self::STATUS_SEND_NO => '未发货', self::STATUS_REFUND => '已退款'];
        return Util::getStatusText($type, $array);
    }

    public static function getOrderGoods($id) {
        return OrderGoods::find()->where(['c_id' => explode(',', $id)])->all();
    }

    public static function getRefundGoodsCount($order_id) {
        return static::find()->where(['c_order_id' => $order_id, 'c_is_send' => self::STATUS_REFUND])->count();
    }

    /**
     * 按订单ID获取购买后赠送积分与经验值
     * @param type $order_id
     * @return type
     */
    public static function findPointExp($order_id) {
        $result = static::findId(['c_order_id' => $order_id, 'c_is_send' => self::STATUS_SEND_YES]);
        $point = 0;
        $exp = 0;
        foreach ($result as $v) {
            $point += $v->c_point * $v->c_count;
            $exp += $v->c_exp * $v->c_count;
        }
        return [$point, $exp];
    }

    public static function add($order_goods, $order_id, $order_no) {
        //创建订单删除原订单库存增加
        if (self::deleteOrderGoods($order_id)) {
            foreach ($order_goods as $v) {
                $model = new OrderGoods();
                $model->c_order_id = $order_id;
                $model->c_order_no = $order_no;
                $model->c_goods_id = $v['goods_id'];
                $model->c_picture = $v['picture'];
                $model->c_title = $v['title'];
                $model->c_number = $v['number'];
                $model->c_sell_price = $v['sell_price'];
                $model->c_real_price = $v['real_price'];
                $model->c_weight = $v['weight'];
                $model->c_point = $v['point'];
                $model->c_exp = $v['exp'];
                $model->c_count = $v['buy_count'];
                $model->c_create_time = time();
                if ($model->save()) {
                    //创建订单判断商品库存
                    if (Yii::$app->params['store_status'] === '1') {
                        $model->goods->c_store_count -= $v['buy_count'];
                        if (empty($model->goods->save(false))) {
                            return false;
                        }
                    }
                } else {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    private static function deleteOrderGoods($order_id) {
        $data = OrderGoods::find()->where(['c_order_id' => $order_id])->all();
        if ($data) {
            foreach ($data as $model) {
                //创建订单判断商品库存
                if (Yii::$app->params['store_status'] === '1') {
                    $model->goods->c_store_count += $model->c_count;
                    if (empty($model->goods->save(false))) {
                        return false;
                    }
                }
                if (empty($model->delete())) {
                    return false;
                }
            }
        }
        return true;
    }

}
