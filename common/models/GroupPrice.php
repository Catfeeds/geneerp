<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%group_price}}".
 *
 * @property string $c_id
 * @property string $c_goods_id
 * @property string $c_group_id
 * @property string $c_price
 */
class GroupPrice extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%group_price}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_goods_id', 'c_group_id'], 'integer'],
            [['c_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_goods_id' => '商品ID',
            'c_group_id' => '用户组ID',
            'c_price' => '价格',
        ];
    }

}
