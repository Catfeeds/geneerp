<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_notify}}".
 *
 * @property string $c_id
 * @property string $c_mobile
 * @property string $c_email
 * @property integer $c_status
 * @property string $c_goods_id
 * @property string $c_user_id
 * @property string $c_notify_time
 * @property string $c_create_time
 */
class GoodsNotify extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_notify}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_status', 'c_goods_id', 'c_user_id', 'c_notify_time', 'c_create_time'], 'integer'],
            [['c_mobile'], 'string', 'max' => 11],
            [['c_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_mobile' => '手机',
            'c_email' => 'email',
            'c_status' => '1未通知 2仅邮件通知 3仅短信通知 4已邮件、短信通知',
            'c_goods_id' => '商品ID',
            'c_user_id' => '用户ID',
            'c_notify_time' => '通知时间',
            'c_create_time' => '创建时间',
        ];
    }

}
