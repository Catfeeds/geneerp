<?php

namespace common\models;

use common\extensions\Util;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property string $c_id
 * @property string $c_mobile
 * @property string $c_user_name
 * @property string $c_full_name
 * @property string $c_admin_name
 * @property string $c_email
 * @property string $c_phone
 * @property string $c_title
 * @property string $c_note
 * @property integer $c_sex
 * @property integer $c_reply_type
 * @property integer $c_is_delete
 * @property integer $c_status
 * @property integer $c_type
 * @property string $c_user_id
 * @property string $c_admin_id
 * @property string $c_reply_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Feedback extends _CommonModel {

    public $content;
    public $reply_content;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_sex', 'c_reply_type', 'c_is_delete', 'c_status', 'c_type', 'c_user_id', 'c_admin_id', 'c_reply_time', 'c_create_time'], 'integer'],
            [['c_update_time', 'content', 'reply_content'], 'safe'],
            [['c_mobile'], 'string', 'max' => 11],
            [['c_user_name', 'c_full_name', 'c_admin_name'], 'string', 'max' => 20],
            [['c_email', 'c_phone'], 'string', 'max' => 50],
            [['c_title', 'c_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_mobile' => '手机号',
            'c_user_name' => '用户账号',
            'c_full_name' => '姓名',
            'c_admin_name' => '回复人用户名',
            'c_email' => '邮箱',
            'c_phone' => '联系电话',
            'c_title' => '主题',
            'c_note' => '备注',
            'c_sex' => '性别', // 1男 2女 3保密
            'c_reply_type' => '回复类型', // 0不通知 1邮件通知 2短信通知 3电话回访
            'c_is_delete' => '删除状态', // 1正常 2删除 3彻底删除
            'c_status' => '状态',
            'c_type' => '类型',
            'c_user_id' => '用户ID',
            'c_admin_id' => '管理员ID',
            'c_reply_time' => '回复时间',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
            'content' => '反馈内容',
            'reply_content' => '回复内容',
        ];
    }

    public function getFeedbackText() {
        return $this->hasOne(FeedbackText::className(), ['c_feedback_id' => 'c_id']);
    }

    public static function getStatus($type = null) {
        $array = [1 => '已处理', 2 => '未处理', 3 => '处理中'];
        return Util::getStatusText($type, $array);
    }

    public static function getReplyType($type = null) {
        $array = [0 => '不用通知', 1 => '邮件通知', 2 => '短信通知', 3 => '电话回访'];
        return Util::getStatusText($type, $array);
    }

    /**
     * 保存之后处理相关数据
     * @param type $insert
     * @param type $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ($this->content) {
            $data['c_content'] = $this->content;
            FeedbackText::addEdit($this->c_id, $data);
        }
        if ($this->reply_content) {
            $data['c_reply_content'] = $this->reply_content;
            FeedbackText::addEdit($this->c_id, $data);
        }
    }

}
