<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%user_acount_log}}".
 *
 * @property string $c_id
 * @property string $c_order_no
 * @property string $c_admin_name
 * @property string $c_note
 * @property string $c_amount_old
 * @property string $c_amount
 * @property string $c_amount_new
 * @property string $c_frozen_amount_old
 * @property string $c_frozen_amount
 * @property string $c_frozen_amount_new
 * @property integer $c_type
 * @property string $c_note_type
 * @property string $c_user_id
 * @property string $c_admin_id
 * @property string $c_order_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserAcountLog extends _CommonModel {

    const ACOUNT_ADMIN_ADD = 90; //管理员充值
    const ACOUNT_ADMIN_SUB = 91; //管理员扣除
    const ACOUNT_ADMIN_PAY_ORDER = 92; //管理员协助用户支付订单
    const ACOUNT_USER_ONLINE = 10; //用户在线充值
    const ACOUNT_USER_PAY_ORDER = 11; //用户支付订单
    const ACOUNT_USER_REFUNDMENT = 12; //用户退款
    const ACOUNT_USER_WITHDRAWALS = 13; //用户提现
    const ACOUNT_USER_CANCEL_ORDER = 14; //用户取消已支付未发货订单

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return '{{%user_acount_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_amount_old', 'c_amount', 'c_amount_new', 'c_frozen_amount_old', 'c_frozen_amount', 'c_frozen_amount_new'], 'number'],
            [['c_type', 'c_note_type', 'c_user_id', 'c_admin_id', 'c_order_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_order_no'], 'string', 'max' => 20],
            [['c_admin_name'], 'string', 'max' => 50],
            [['c_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_order_no' => '订单号',
            'c_admin_name' => '管理员用户名',
            'c_note' => '备注说明',
            'c_amount_old' => '账户修改前金额',
            'c_amount' => '修改金额',
            'c_amount_new' => '账户修改后金额',
            'c_frozen_amount_old' => '冻结账户修改前金额',
            'c_frozen_amount' => '修改金额',
            'c_frozen_amount_new' => '冻结账户修改后金额',
            'c_type' => '日志类型', // 1进账 2出账
            'c_note_type' => '备注类型',
            'c_user_id' => '用户ID',
            'c_admin_id' => '管理员ID',
            'c_order_id' => '订单ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['c_id' => 'c_user_id']);
    }

    public static function getType($type = null) {
        $array = [self::STATUS_YES => '进账', self::STATUS_NO => '出账'];
        return Util::getStatusText($type, $array);
    }

    public static function getNote($type = null) {
        $array = [
            self::ACOUNT_ADMIN_ADD => '管理员充值',
            self::ACOUNT_ADMIN_SUB => '管理员扣除',
            self::ACOUNT_ADMIN_PAY_ORDER => '管理员协助用户支付订单',
            self::ACOUNT_USER_ONLINE => '用户在线充值',
            self::ACOUNT_USER_PAY_ORDER => '用户支付订单',
            self::ACOUNT_USER_CANCEL_ORDER => '用户取消已支付未发货订单',
            self::ACOUNT_USER_REFUNDMENT => '用户退款',
            self::ACOUNT_USER_WITHDRAWALS => '用户提现',
        ];
        return Util::getStatusText($type, $array);
    }

    public static function add($data, $user_type = User::CREATE_ADMIN) {
        $model = new UserAcountLog();
        if ($user_type == User::CREATE_ADMIN) {
            $model->c_admin_id = Yii::$app->user->identity->c_id;
            $model->c_admin_name = Yii::$app->user->identity->c_admin_name;
        }
        $model->attributes = $data;
        $model->c_create_time = time();
        return $model->save();
    }

}
