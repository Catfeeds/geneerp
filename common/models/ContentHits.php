<?php

namespace common\models;

/**
 * This is the model class for table "{{%content_hits}}".
 *
 * @property string $c_content_id
 * @property string $c_pc_count
 * @property string $c_h5_count
 * @property string $c_app_count
 * @property string $c_create_time
 * @property string $c_update_time
 */
class ContentHits extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%content_hits}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_content_id'], 'required'],
            [['c_content_id', 'c_pc_count', 'c_h5_count', 'c_app_count', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_content_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_content_id' => '内容ID',
            'c_pc_count' => 'PC点击数量',
            'c_h5_count' => 'H5点击数量',
            'c_app_count' => 'APP点击数量',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function add($id) {
        $model = new ContentHits();
        $model->c_content_id = $id;
        $model->c_create_time = time();
        return $model->save();
    }

}
