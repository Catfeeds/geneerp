<?php

namespace common\models;

use common\extensions\Util;

/**
 * This is the model class for table "{{%ad_position}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_note
 * @property integer $c_height
 * @property integer $c_width
 * @property integer $c_count
 * @property integer $c_type
 * @property integer $c_is_count
 * @property integer $c_status
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class AdPosition extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%ad_position}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_note', 'c_height', 'c_width', 'c_count', 'c_sort'], 'filter', 'filter' => 'trim'],
            /**
             * 自动生成规则
             */
            [['c_title', 'c_status', 'c_sort'], 'required'],
            [['c_height', 'c_width', 'c_count', 'c_type', 'c_is_count', 'c_status', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
            [['c_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '标题',
            'c_note' => '备注',
            'c_height' => '图片高度',
            'c_width' => '图片高度',
            'c_count' => '广告显示数量',
            'c_type' => '类型', // 1系统广告位 2自定义广告位
            'c_is_count' => '统计点击', // 1统计 2不统计
            'c_status' => '状态',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getType($type = null) {
        $array = [1 => '系统广告位', 2 => '自定义广告位'];
        return Util::getStatusText($type, $array);
    }

}
