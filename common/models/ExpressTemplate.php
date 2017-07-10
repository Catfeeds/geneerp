<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%express_template}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_picture
 * @property integer $c_width
 * @property integer $c_height
 * @property integer $c_status
 * @property string $c_config
 */
class ExpressTemplate extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%express_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_width', 'c_height', 'c_status'], 'integer'],
            [['c_config'], 'string'],
            [['c_title'], 'string', 'max' => 50],
            [['c_picture'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '快递单模板名字',
            'c_picture' => '背景图片路径',
            'c_width' => '背景图片路径',
            'c_height' => '背景图片路径',
            'c_status' => '状态 1正常 2无效',
            'c_config' => '快递单结构数据 JSON格式',
        ];
    }

}
