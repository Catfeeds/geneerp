<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_message}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_body
 * @property integer $c_type
 * @property string $c_user_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserMessage extends _CommonModel {

    const MESSAGE_SYSTEM = 1;
    const MESSAGE_USER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_type', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
            [['c_body'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_title' => '主题',
            'c_body' => '内容',
            'c_type' => '信息类型', // 1系统信息 2站内信
            'c_user_id' => '用户ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function add($user_id, $title, $body, $type = self::MESSAGE_USER) {
        $model = new UserMessage();
        $model->c_user_id = $user_id;
        $model->c_type = $type;
        $model->c_title = $title;
        $model->c_body = $body;
        $model->c_create_time = time();
        return $model->save();
    }

}
