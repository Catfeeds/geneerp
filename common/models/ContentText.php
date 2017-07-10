<?php

namespace common\models;

/**
 * This is the model class for table "{{%content_text}}".
 *
 * @property string $c_content_id
 * @property string $c_pc_content
 * @property string $c_h5_content
 * @property string $c_app_content
 * @property string $c_create_time
 * @property string $c_update_time
 */
class ContentText extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%content_text}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_content_id'], 'required'],
            [['c_content_id', 'c_create_time'], 'integer'],
            [['c_pc_content', 'c_h5_content', 'c_app_content'], 'string'],
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
            'c_pc_content' => 'PC内容正文',
            'c_h5_content' => 'H5内容正文',
            'c_app_content' => 'APP内容正文',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function addEdit($content_id, $pc_content, $h5_content, $app_content) {
        $model = ContentText::findOne($content_id);
        if ($model) {
            $model->c_pc_content = $pc_content;
            $model->c_h5_content = $h5_content;
            $model->c_app_content = $app_content;
            return $model->save();
        } else {
            return self::add($content_id, $pc_content, $h5_content, $app_content);
        }
    }

    private static function add($content_id, $pc_content, $h5_content, $app_content) {
        $model = new ContentText();
        $model->c_content_id = $content_id;
        $model->c_pc_content = $pc_content;
        $model->c_h5_content = $h5_content;
        $model->c_app_content = $app_content;
        $model->c_create_time = time();
        return $model->save();
    }

}
