<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_card}}".
 *
 * @property string $c_id
 * @property string $c_card_id
 * @property string $c_user_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserCard extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_card_id', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_card_id' => '卡号ID',
            'c_user_id' => '用户ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
