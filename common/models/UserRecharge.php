<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_recharge}}".
 *
 * @property string $c_id
 * @property string $c_recharge_no
 * @property string $c_content
 * @property string $c_amount
 * @property integer $c_status
 * @property string $c_payment_id
 * @property string $c_user_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserRecharge extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_recharge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_amount'], 'number'],
            [['c_status', 'c_payment_id', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_recharge_no'], 'string', 'max' => 50],
            [['c_content'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_recharge_no' => '充值单号',
            'c_content' => '附言',
            'c_amount' => '充值金额',
            'c_status' => '充值状态 1成功 2失败',
            'c_payment_id' => '充值方式ID',
            'c_user_id' => '用户ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
