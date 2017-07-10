<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%takeself}}".
 *
 * @property string $c_id
 * @property string $c_mobile
 * @property string $c_title
 * @property string $c_phone
 * @property string $c_address
 * @property integer $c_status
 * @property string $c_province_id
 * @property string $c_city_id
 * @property string $c_area_id
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Takeself extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%takeself}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_phone', 'c_mobile', 'c_address', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title', 'c_status', 'c_sort', 'c_province_id', 'c_city_id'], 'required'],
            [['c_area_id'], 'default', 'value' => 0],
            [['c_status', 'c_province_id', 'c_city_id', 'c_area_id', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_mobile'], 'string', 'max' => 11],
            [['c_title'], 'string', 'max' => 20],
            [['c_phone'], 'string', 'max' => 50],
            [['c_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_mobile' => '手机号',
            'c_title' => '名称',
            'c_phone' => '电话',
            'c_address' => '街道地址',
            'c_status' => '状态',
            'c_province_id' => '省份',
            'c_city_id' => '市级',
            'c_area_id' => '地区',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
