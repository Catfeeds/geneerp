<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_model}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsModel extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title'], 'required'],
            [['c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '模型名称',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getGoodsModelAttr() {
        return $this->hasMany(GoodsModelAttr::className(), ['c_model_id' => 'c_id']);
    }

    /**
     * 保存之后处理相关数据
     * @param type $insert
     * @param type $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        GoodsModelAttr::addMore($this->c_id, Yii::$app->request->post('GoodsModelAttr'));
    }

    /**
     * 删除之前处理相关数据
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {
            GoodsModelAttr::deleteAll(['c_model_id' => $this->c_id]);
            return true;
        }
        return false;
    }

}
