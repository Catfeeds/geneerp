<?php

namespace common\models;

/**
 * This is the model class for table "{{%content_label}}".
 *
 * @property string $c_id
 * @property string $c_content_id
 * @property integer $c_type
 */
class ContentLabel extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%content_label}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_content_id', 'c_type'], 'integer'],
            [['c_content_id', 'c_type'], 'unique', 'targetAttribute' => ['c_content_id', 'c_type'], 'message' => 'The combination of 内容ID and 标签类型 1置顶 2推荐 3热门 has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_content_id' => '内容ID',
            'c_type' => '标签类型 1置顶 2推荐 3热门',
        ];
    }

    public static function addMore($content_id, $array) {
        if ($array) {
            ContentLabel::deleteAll(['c_content_id' => $content_id]);
            $model = new ContentLabel();
            foreach ($array as $type) {
                $obj = clone $model;
                $obj->c_content_id = $content_id;
                $obj->c_type = $type;
                $obj->save();
            }
        }
    }

}
