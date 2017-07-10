<?php

namespace common\models;

/**
 * This is the model class for table "{{%goods_attr}}".
 *
 * @property string $c_id
 * @property string $c_attr_value
 * @property string $c_attr_id
 * @property string $c_goods_id
 * @property string $c_model_id
 */
class GoodsAttr extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_attr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_attr_id', 'c_goods_id', 'c_model_id'], 'integer'],
            [['c_attr_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_attr_value' => '属性值',
            'c_attr_id' => '属性ID',
            'c_goods_id' => '商品ID',
            'c_model_id' => '模型ID',
        ];
    }

    public static function addMore($goods_id, $model_id, $array) {
        if ($array) {
            $model = new GoodsAttr();
            GoodsAttr::deleteAll(['c_goods_id' => $goods_id]);
            foreach ($array as $type => $type_array) {
                if ($type_array) {
                    foreach ($type_array as $attr_id => $value) {
                        if ($value) {
                            $obj = clone $model;
                            $obj->c_goods_id = $goods_id;
                            $obj->c_model_id = $model_id;
                            $obj->c_attr_id = $attr_id;
                            $obj->c_attr_value = $type == 2 ? implode(',', $value) : $value; //type 1单选 2复选 3下拉 4输入框;
                            $obj->save();
                        }
                    }
                }
            }
        }
    }

}
