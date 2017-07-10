<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%content_goods_relation}}".
 *
 * @property string $c_id
 * @property string $c_goods_id
 * @property string $c_content_id
 */
class ContentGoodsRelation extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%content_goods_relation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_goods_id', 'c_content_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_goods_id' => '商品ID',
            'c_content_id' => '内容ID',
        ];
    }

}
