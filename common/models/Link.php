<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%link}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_url
 * @property string $c_picture
 * @property string $c_note
 * @property integer $c_type
 * @property integer $c_status
 * @property string $c_sort
 * @property string $c_hits
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Link extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_url', 'c_note', 'c_sort'], 'filter', 'filter' => 'trim'],
            /**
             * 自动生成规则
             */
            [['c_title', 'c_status', 'c_sort'], 'required'],
            [['c_type', 'c_status', 'c_sort', 'c_hits', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
            [['c_url', 'c_picture'], 'string', 'max' => 255],
            [['c_note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '标题',
            'c_url' => '链接',
            'c_picture' => '图片',
            'c_note' => '备注',
            'c_type' => '链接类型', // 1友情链接 2常用网址 3媒体合作
            'c_status' => '状态', // 1已审核 2待审核 3审核失败
            'c_sort' => '排序',
            'c_hits' => '点击次数',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getType($type = null) {
        $array = [1 => '友情链接', 2 => '常用链接', 3 => '合作伙伴'];
        return Util::getStatusText($type, $array);
    }

    public static function getStatus($type = null) {
        $array = [1 => '已审核', 2 => '待审核', 3 => '审核失败'];
        return Util::getStatusText($type, $array);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->c_picture = Yii::$app->request->post('picture_list', ''); //本次新增图片路径
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
