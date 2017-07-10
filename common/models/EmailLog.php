<?php

namespace common\models;

/**
 * This is the model class for table "{{%email_log}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_email
 * @property string $c_body
 * @property string $c_param
 * @property string $c_error
 * @property integer $c_type
 * @property integer $c_status
 * @property string $c_user_id
 * @property string $c_send_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class EmailLog extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%email_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_body', 'c_param', 'c_error'], 'string'],
            [['c_type', 'c_status', 'c_user_id', 'c_send_time', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title', 'c_email'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '邮件标题',
            'c_email' => '邮箱',
            'c_body' => '邮件正文',
            'c_param' => '模板替换参数  JSON格式',
            'c_error' => '邮件发送错误提示信息',
            'c_type' => '消息类型',
            'c_status' => '状态', // 1成功 2失败 3未发送
            'c_user_id' => '用户ID',
            'c_send_time' => '预约发送时间', // 可以用去定时发送
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    /**
     * 新增邮件日志
     * @param type $type 消息类型
     * @param type $email 邮箱
     * @param type $title 邮件标题
     * @param type $param 模板替换参数
     * @return boolean
     */
    public static function add($type, $email, $title, $body, $param) {
        $model = new EmailLog();
        $model->c_type = $type;
        $model->c_email = $email;
        $model->c_title = $title;
        $model->c_body = strip_tags($body);
        $model->c_param = json_encode($param, JSON_UNESCAPED_UNICODE);
        $model->c_user_id = isset($param['user_id']) ? $param['user_id'] : 0;
        $model->c_create_time = time();
        $model->c_status = 3;
        $result = $model->save();
        if ($result) {
            return $model->c_id;
        }
        return false;
    }

}
