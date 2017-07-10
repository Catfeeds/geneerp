<?php

namespace backend\models;

use common\models\_CommonModel;

/**
 * This is the model class for table "{{%admin_role}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property integer $c_status
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class AdminRole extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%admin_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 默认值
             */
            ['c_status', 'default', 'value' => self::STATUS_NO],
            ['c_sort', 'default', 'value' => 0],
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title'], 'required'],
            [['c_status', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '角色名称',
            'c_status' => '状态',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
