<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%order_log}}".
 *
 * @property string $c_id
 * @property string $c_order_no
 * @property string $c_user_name
 * @property string $c_admin_name
 * @property string $c_note
 * @property integer $c_status
 * @property integer $c_action_type
 * @property string $c_order_id
 * @property string $c_admin_id
 * @property string $c_user_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class OrderLog extends _CommonModel {

    const STATUS_CREATE = 1; //创建
    const STATUS_PAY = 2; //支付
    const STATUS_CANCEL = 3; //取消
    const STATUS_DELIVERY = 4; //发货
    const STATUS_REFUNDMENT = 5; //退款
    const STATUS_FINISH = 6; //完成
    const STATUS_DELETE = 7; //删除

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return '{{%order_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_status', 'c_action_type', 'c_order_id', 'c_admin_id', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_order_no', 'c_user_name'], 'string', 'max' => 20],
            [['c_admin_name'], 'string', 'max' => 50],
            [['c_note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_order_no' => '订单号',
            'c_user_name' => '用户名',
            'c_admin_name' => '管理员用户名',
            'c_note' => '备注',
            'c_status' => '状态 1成功 2失败',
            'c_action_type' => '动作类型',
            'c_order_id' => '订单ID',
            'c_admin_id' => '管理员ID',
            'c_user_id' => '用户ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getActionType($type = null) {
        $array = [
            self::STATUS_CREATE => '创建',
            self::STATUS_PAY => '支付',
            self::STATUS_CANCEL => '取消',
            self::STATUS_DELIVERY => '发货',
            self::STATUS_REFUNDMENT => '退款',
            self::STATUS_FINISH => '完成',
            self::STATUS_DELETE => '删除'
        ];
        return Util::getStatusText($type, $array);
    }

    public static function add($data, $create_type = self::CREATE_ADMIN) {
        $model = new OrderLog();
        $model->c_create_time = time();
        if ($create_type == self::CREATE_ADMIN) {
            $model->c_admin_id = Yii::$app->user->identity->c_id;
            $model->c_admin_name = Yii::$app->user->identity->c_admin_name;
        } else {
            $model->c_user_id = Yii::$app->user->identity->c_id;
            $model->c_user_name = Yii::$app->user->identity->c_user_name;
        }
        $model->attributes = $data;
        return $model->save();
    }

}
