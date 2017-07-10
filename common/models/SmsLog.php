<?php

namespace common\models;

/**
 * This is the model class for table "{{%sms_log}}".
 *
 * @property string $c_id
 * @property string $c_mobile
 * @property string $c_sms_request_id
 * @property string $c_sms_model
 * @property string $c_sms_code
 * @property string $c_sms_msg
 * @property string $c_param
 * @property string $c_body
 * @property integer $c_type
 * @property integer $c_status
 * @property string $c_user_id
 * @property string $c_send_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class SmsLog extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%sms_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_type', 'c_status', 'c_user_id', 'c_send_time', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_mobile'], 'string', 'max' => 11],
            [['c_sms_request_id'], 'string', 'max' => 50],
            [['c_sms_model', 'c_sms_code'], 'string', 'max' => 100],
            [['c_sms_msg', 'c_param', 'c_body'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_mobile' => '手机号',
            'c_sms_request_id' => '发送短信的消息ID',
            'c_sms_model' => '返回结果',
            'c_sms_code' => '错误码',
            'c_sms_msg' => '错误描述',
            'c_param' => '模板替换参数  JSON格式',
            'c_body' => '短信内容',
            'c_type' => '消息类型',
            'c_status' => '状态', // 1成功 2失败 3未发送
            'c_user_id' => '用户ID',
            'c_send_time' => '预约发送时间', //可以用去定时发送
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function add($type, $mobile, $body, $param) {
        $model = new SmsLog();
        $model->c_type = $type;
        $model->c_mobile = $mobile;
        $model->c_body = $body;
        $model->c_param = json_encode($param, JSON_UNESCAPED_UNICODE);
        $model->c_user_id = isset($param['user_id']) ? $param['user_id'] : 0;
        $model->c_create_time = time();
        $model->c_status = 3;
        return $model->save();
    }

}
