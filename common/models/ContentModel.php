<?php

namespace common\models;

use common\extensions\Util;

/**
 * This is the model class for table "{{%content_model}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_template_list
 * @property string $c_template_page
 * @property string $c_config
 * @property integer $c_pagesize
 * @property integer $c_type
 * @property integer $c_status
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class ContentModel extends _CommonModel {

    public $field_list;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%content_model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_title', 'c_status', 'c_sort'], 'required'],
            [['c_config'], 'string'],
            [['c_pagesize', 'c_type', 'c_status', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time', 'field_list'], 'safe'],
            [['c_title', 'c_template_list', 'c_template_page'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '模型名称',
            'c_template_list' => '列表模板',
            'c_template_page' => '详情模板',
            'c_config' => '配置',
            'c_pagesize' => '列表每页显示数目',
            'c_type' => '类型', // 1系统原型 2自定义模型
            'c_status' => '状态',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
            'field_list' => '字段显示'
        ];
    }

    public static function getType($type = null) {
        $array = [1 => '系统原型', 2 => '自定义模型'];
        return Util::getStatusText($type, $array);
    }

    public static function getKey() {
        return [
            'c_special_id' => '选择专题',
            'c_picture' => '上传图片',
            'c_file' => '上传附件',
            'c_source' => '选择来源',
            'c_short' => '短标题',
            'c_seo' => '标题优化',
            'c_keyword' => '关键词',
            'c_description' => '摘要',
            'c_h5_content' => 'H5内容',
            'c_app_content' => 'APP内容',
            'label' => '设置标签',
        ];
    }

    public static function getContentModelJson() {
        $data = [];
        $result = ContentModel::find()->all();
        foreach ($result as $v) {
            $data[$v->c_id] = json_decode($v->c_config, true);
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->c_config = json_encode($this->field_list);
            return true;
        }
        return false;
    }

}
