<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_comment}}".
 *
 * @property string $c_id
 * @property string $c_order_no
 * @property string $c_admin_name
 * @property string $c_content
 * @property string $c_reply_content
 * @property integer $c_point
 * @property integer $c_is_delete
 * @property integer $c_status
 * @property string $c_order_goods_id
 * @property string $c_user_id
 * @property string $c_admin_id
 * @property string $c_reply_time
 * @property string $c_order_time
 * @property integer $c_comment_ip
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsComment extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_order_no'], 'required'],
            [['c_point', 'c_is_delete', 'c_status', 'c_order_goods_id', 'c_user_id', 'c_admin_id', 'c_reply_time', 'c_order_time', 'c_comment_ip', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_order_no', 'c_admin_name'], 'string', 'max' => 20],
            [['c_content', 'c_reply_content'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_order_no' => '订单号',
            'c_admin_name' => '回复人 管理员用户名',
            'c_content' => '评论内容',
            'c_reply_content' => '回复评论',
            'c_point' => '评论分数',
            'c_is_delete' => '删除状态 1正常 2删除 3彻底删除',
            'c_status' => '审核状态 1已审核 2未审核',
            'c_order_goods_id' => '订单商品ID',
            'c_user_id' => '用户ID',
            'c_admin_id' => '管理员ID',
            'c_reply_time' => '回复时间',
            'c_order_time' => '创建订单时间',
            'c_comment_ip' => '评论IP',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
