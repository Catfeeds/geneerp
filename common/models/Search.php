<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%search}}".
 *
 * @property string $c_id
 * @property string $c_keyword
 * @property integer $c_type
 * @property string $c_count
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Search extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%search}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_type', 'c_count', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_keyword'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'C ID',
            'c_keyword' => '搜索关键字',
            'c_type' => '搜索类型 1商品 2内容',
            'c_count' => '搜索次数',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
