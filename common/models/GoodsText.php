<?php

namespace common\models;

/**
 * This is the model class for table "{{%goods_text}}".
 *
 * @property string $c_goods_id
 * @property string $c_pc_content
 * @property string $c_h5_content
 * @property string $c_app_content
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsText extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_text}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_goods_id'], 'required'],
            [['c_goods_id', 'c_create_time'], 'integer'],
            [['c_pc_content', 'c_h5_content', 'c_app_content'], 'string'],
            [['c_update_time'], 'safe'],
            [['c_goods_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_goods_id' => '商品ID',
            'c_pc_content' => 'PC商品内容',
            'c_h5_content' => 'H5商品内容',
            'c_app_content' => 'APP商品内容',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function addEdit($goods_id, $pc_content, $h5_content, $app_content) {
        $model = static::findOne($goods_id);
        if (empty($model)) {
            $model = new GoodsText();
            $model->c_goods_id = $goods_id;
            $model->c_create_time = time();
        }
        $model->c_pc_content = $pc_content;
        $model->c_h5_content = $h5_content;
        $model->c_app_content = $app_content;
        return $model->save();
    }

}
