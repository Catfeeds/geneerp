<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_brand}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_picture
 * @property string $c_url
 * @property string $c_category_ids
 * @property string $c_seo
 * @property string $c_keyword
 * @property string $c_description
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsBrand extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_seo', 'c_keyword', 'c_url', 'c_description', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_sort', 'c_create_time'], 'integer'],
            [['c_update_time', 'c_category_ids'], 'safe'],
            [['c_title', 'c_picture', 'c_url', 'c_seo', 'c_keyword', 'c_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '品牌名称',
            'c_picture' => '图片地址',
            'c_url' => '网址',
            'c_category_ids' => '品牌类别',
            'c_seo' => '标题优化',
            'c_keyword' => '关键词',
            'c_description' => '描述',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->c_picture = Yii::$app->request->post('picture_list', ''); //本次新增图片路径
            $this->c_category_ids = implode(',', $this->c_category_ids);
            return true;
        }
        return false;
    }

    /**
     * 保存之后处理相关数据
     * @param type $insert
     * @param type $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        //图片处理
        Upload::updateFile($insert, $this->c_id);
    }

    /**
     * 删除之前处理相关数据
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {
            Upload::deleteFile($this->c_picture, true);
            return true;
        }
        return false;
    }

}
