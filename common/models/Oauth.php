<?php

namespace common\models;

/**
 * This is the model class for table "{{%oauth}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_oatuh_id
 * @property string $c_description
 * @property string $c_logo
 * @property string $c_api_key
 * @property string $c_api_secret
 * @property string $c_url
 * @property integer $c_status
 * @property string $c_sort
 */
class Oauth extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%oauth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_description', 'c_logo', 'c_api_key', 'c_api_secret', 'c_url', 'c_title', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title', 'c_status', 'c_sort'], 'required'],
            [['c_status', 'c_sort'], 'integer'],
            [['c_title', 'c_oatuh_id'], 'string', 'max' => 100],
            [['c_description', 'c_logo', 'c_api_key', 'c_api_secret', 'c_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '名称',
            'c_oatuh_id' => '接口标识',
            'c_description' => '描述',
            'c_logo' => 'logo',
            'c_api_key' => 'API key',
            'c_api_secret' => 'API secret 或 API id',
            'c_url' => '申请地址',
            'c_status' => '状态',
            'c_sort' => '排序',
        ];
    }

}
