<?php

namespace common\models;

/**
 * This is the model class for table "{{%goods_label}}".
 *
 * @property string $c_id
 * @property string $c_goods_id
 * @property integer $c_type
 */
class GoodsLabel extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_label}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_goods_id', 'c_type'], 'integer'],
            [['c_goods_id', 'c_type'], 'unique', 'targetAttribute' => ['c_goods_id', 'c_type'], 'message' => 'The combination of 商品ID and 标签类型 1最新商品 2特价商品 3热卖排行 4推荐商品 has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_goods_id' => '商品ID',
            'c_type' => '标签类型 1最新商品 2特价商品 3热卖排行 4推荐商品',
        ];
    }

    public static function addMore($goods_id, $array) {
        if ($array) {
            GoodsLabel::deleteAll(['c_goods_id' => $goods_id]);
            $model = new GoodsLabel();
            foreach ($array as $type) {
                $obj = clone $model;
                $obj->c_goods_id = $goods_id;
                $obj->c_type = $type;
                $obj->save();
            }
        }
    }

}
