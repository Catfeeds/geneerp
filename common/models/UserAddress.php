<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_address}}".
 *
 * @property string $c_id
 * @property string $c_postcode
 * @property string $c_mobile
 * @property string $c_full_name
 * @property string $c_phone
 * @property string $c_email
 * @property string $c_address
 * @property integer $c_status
 * @property integer $c_is_default
 * @property integer $c_is_delete
 * @property string $c_province_id
 * @property string $c_city_id
 * @property string $c_area_id
 * @property string $c_user_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserAddress extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_status', 'c_is_default', 'c_is_delete', 'c_province_id', 'c_city_id', 'c_area_id', 'c_user_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_postcode'], 'string', 'max' => 6],
            [['c_mobile'], 'string', 'max' => 11],
            [['c_full_name'], 'string', 'max' => 20],
            [['c_phone', 'c_email'], 'string', 'max' => 50],
            [['c_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_postcode' => '邮政编码',
            'c_mobile' => '手机号',
            'c_full_name' => '姓名',
            'c_phone' => '电话',
            'c_email' => '邮箱',
            'c_address' => '街道地址',
            'c_status' => '状态 1正常 2无效',
            'c_is_default' => '是否为默认发送地址 1默认 2非默认',
            'c_is_delete' => '删除状态 1正常 2删除 3彻底删除',
            'c_province_id' => '省份ID',
            'c_city_id' => '市级ID',
            'c_area_id' => '地区ID',
            'c_user_id' => '用户ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
