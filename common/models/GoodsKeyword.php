<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_keyword}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property integer $c_is_hot
 * @property string $c_goods_count
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsKeyword extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_keyword}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_is_hot', 'c_goods_count', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_title' => '关键词',
            'c_is_hot' => '是否为热门 1热门 2非热门',
            'c_goods_count' => '商品数量',
            'c_sort' => '关键词排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
