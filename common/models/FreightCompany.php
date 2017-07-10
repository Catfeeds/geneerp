<?php

namespace common\models;

/**
 * This is the model class for table "{{%freight_company}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_type
 * @property string $c_url
 * @property integer $c_status
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class FreightCompany extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%freight_company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_status', 'c_sort'], 'required'],
            [['c_title', 'c_type', 'c_url', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_status', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title', 'c_type', 'c_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '物流公司名称',
            'c_type' => '物流公司代号',
            'c_url' => '官方网址',
            'c_status' => '状态',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
