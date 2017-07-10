<?php

namespace common\models;

use Yii;
use common\extensions\Util;
use common\messages\Common;

/**
 * This is the model class for table "{{%content_category}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_short
 * @property string $c_url
 * @property string $c_seo
 * @property string $c_keyword
 * @property string $c_description
 * @property string $c_picture
 * @property integer $c_home_block
 * @property integer $c_status
 * @property string $c_model_id
 * @property string $c_parent_id
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class ContentCategory extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%content_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_short', 'c_url', 'c_seo', 'c_keyword', 'c_description', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title', 'c_status', 'c_sort', 'c_parent_id', 'c_model_id'], 'required'],
            [['c_home_block', 'c_status', 'c_model_id', 'c_parent_id', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
            [['c_short'], 'string', 'max' => 150],
            [['c_url', 'c_seo', 'c_keyword', 'c_description', 'c_picture'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '类别名称',
            'c_short' => '类别短名称',
            'c_url' => '跳转网址',
            'c_seo' => '标题优化',
            'c_keyword' => '关键词',
            'c_description' => '描述',
            'c_picture' => '缩略图地址',
            'c_home_block' => '首页板块',
            'c_status' => '状态', // 1顶部导航栏 2底部导航栏 3顶部底部显示 4不显示
            'c_model_id' => '内容模型',
            'c_parent_id' => '父级菜单',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getContentCategoryText() {
        return $this->hasOne(ContentCategoryText::className(), ['c_content_category_id' => 'c_id']);
    }

    public function getContentModel() {
        return $this->hasOne(ContentModel::className(), ['c_id' => 'c_model_id']);
    }

    public static function getStatus($type = null) {
        $array = [1 => '顶部导航栏', 2 => '底部导航栏', 3 => '顶部底部显示', 4 => '不显示'];
        return Util::getStatusText($type, $array);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->c_picture = Yii::$app->request->post('picture_list', ''); //本次新增图片路径
            if (!$insert) {
                if ($this->c_parent_id == $this->c_id) { //不可以选择自己为自己的父级
                    $this->addError('c_parent_id', Yii::t('common', Common::COMMON_PARENT_ID));
                    return false;
                }
                if (static::checkSub($this->c_id, $this->c_parent_id)) {//不可以选择自己子类为父级菜单
                    $this->addError('c_parent_id', Yii::t('common', Common::COMMON_SUB_ID));
                    return false;
                }
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
        //图片处理
        Upload::updateFile($insert, $this->c_id);
        //更新编辑器上传图片为已上传
        foreach (Yii::$app->params['editor_dir'] as $v) {
            Upload::updateByPath($this->c_id, Yii::$app->request->post('content_' . $v));
        }
        if ($this->c_model_id == 2) {
            ContentCategoryText::addEdit($this->c_id, Yii::$app->request->post('editor_content'));
        }
    }

    /**
     * 删除之前处理相关数据
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {
            if (static::getSub($this->c_id)) {//请先删除本条记录的子类后再删除
                $this->addError('c_parent_id', Yii::t('common', Common::COMMON_SUB_DELETE_FAIL));
                return false;
            } else {
                Upload::deleteFile($this->c_picture, true);
            }
            return true;
        }
        return false;
    }

}
