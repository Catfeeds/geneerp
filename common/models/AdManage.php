<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%ad_manage}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_url
 * @property string $c_content
 * @property integer $c_type
 * @property integer $c_status
 * @property string $c_position_id
 * @property string $c_sort
 * @property string $c_hits
 * @property string $c_create_time
 * @property string $c_update_time
 */
class AdManage extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%ad_manage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_url', 'c_sort'], 'filter', 'filter' => 'trim'],
            /**
             * 自动生成规则
             */
            [['c_title', 'c_status', 'c_sort', 'c_position_id'], 'required'],
            [['c_content'], 'string'],
            [['c_type', 'c_status', 'c_position_id', 'c_sort', 'c_hits', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
            [['c_url'], 'string', 'max' => 255],
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
            'c_content' => '广告内容 ',
            'c_type' => '广告类型', // 1文字 2图片 3flash 4html
            'c_status' => '状态',
            'c_position_id' => '广告位',
            'c_sort' => '排序',
            'c_hits' => '点击次数',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getAdPosition() {
        return $this->hasOne(AdPosition::className(), ['c_id' => 'c_position_id']);
    }

    public static function getType($type = null) {
        $array = [1 => '文字', 2 => '图片', 3 => 'flash', 4 => 'html'];
        return Util::getStatusText($type, $array);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            //图片处理
            if ($this->c_type == 2) {
                $this->c_content = Yii::$app->request->post('picture_list', '');
            }
            //flash处理
            if ($this->c_type == 3) {
                $this->c_content = Yii::$app->request->post('file_list', '');
            }
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
        //图片或FLASH处理
        if (in_array($this->c_type, [2, 3])) {
            Upload::updateFile($insert, $this->c_id, $this->c_type == 2 ? Upload::UPLOAD_PICTURE : Upload::UPLOAD_FILE);
        }
    }

    /**
     * 删除之前处理相关数据
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {
            if ($this->c_content && in_array($this->c_type, [2, 3])) {
                Upload::deleteFile($this->c_content, true);
            }
            return true;
        }
        return false;
    }

}
