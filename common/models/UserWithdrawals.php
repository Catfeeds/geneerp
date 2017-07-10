<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_withdrawals}}".
 *
 * @property string $c_id
 * @property string $c_full_name
 * @property string $c_reply_content
 * @property string $c_content
 * @property string $c_account
 * @property string $c_account_bank
 * @property string $c_amount
 * @property integer $c_is_delete
 * @property integer $c_status
 * @property integer $c_account_type
 * @property string $c_user_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserWithdrawals extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_withdrawals}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_amount'], 'number'],
            [['c_is_delete', 'c_status', 'c_account_type', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_full_name', 'c_account'], 'string', 'max' => 20],
            [['c_reply_content', 'c_content'], 'string', 'max' => 1000],
            [['c_account_bank'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'C ID',
            'c_full_name' => '姓名',
            'c_reply_content' => '回复附言',
            'c_content' => '附言',
            'c_account' => '账户号',
            'c_account_bank' => '开户行',
            'c_amount' => '金额',
            'c_is_delete' => '删除状态 1正常 2删除 3彻底删除',
            'c_status' => '状态 提现成功 2待审核 3审核通过转账中 4已拒绝',
            'c_account_type' => '提现方式 1银行卡 2支付宝 3微信',
            'c_user_id' => '用户ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
