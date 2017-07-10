<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%oauth_user}}".
 *
 * @property string $c_id
 * @property string $c_oauth_name
 * @property string $c_oauth_id
 * @property string $c_user_id
 * @property string $c_create_time
 */
class OauthUser extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%oauth_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_oauth_id', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_oauth_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_oauth_name' => '第三方平台的用户唯一标识',
            'c_oauth_id' => 'oauth表关联平台id',
            'c_user_id' => '系统内部的用户id',
            'c_create_time' => '绑定时间',
        ];
    }

}
