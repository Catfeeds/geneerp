<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_favorite}}".
 *
 * @property string $c_id
 * @property string $c_user_id
 * @property string $c_goods_id
 * @property integer $c_is_delete
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsFavorite extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_user_id', 'c_goods_id', 'c_is_delete', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_user_id' => '用户ID',
            'c_goods_id' => '商品ID',
            'c_is_delete' => '删除状态 1正常 2删除 3彻底删除',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
