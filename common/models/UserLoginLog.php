<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_login_log}}".
 *
 * @property string $c_id
 * @property string $c_login_name
 * @property string $c_login_password
 * @property integer $c_status
 * @property integer $c_create_type
 * @property integer $c_login_ip
 * @property string $c_create_time
 */
class UserLoginLog extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_login_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_status', 'c_create_type', 'c_login_ip', 'c_create_time'], 'integer'],
            [['c_login_name', 'c_login_password'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_login_name' => '登录名',
            'c_login_password' => '登录密码',
            'c_status' => '登录状态 1成功 2失败',
            'c_create_type' => '来源类型', // 1PC 2H5 3IOS 4Andriod 8其他 9平台
            'c_login_ip' => '最后登录IP',
            'c_create_time' => '创建时间',
        ];
    }

    public static function add($data) {
        $model = new UserLoginLog();
        $model->attributes = $data;
        $model->c_create_time = time();
        $model->c_login_ip = ip2long(Yii::$app->getRequest()->getUserIP());
        return $model->save();
    }

}
