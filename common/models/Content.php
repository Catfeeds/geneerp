<?php

namespace common\models;

use Yii;
use common\extensions\Util;
use common\extensions\String;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_short
 * @property string $c_seo
 * @property string $c_keyword
 * @property string $c_description
 * @property string $c_author
 * @property string $c_editor
 * @property string $c_source_site
 * @property string $c_source_url
 * @property string $c_picture
 * @property string $c_file
 * @property integer $c_create_type
 * @property integer $c_source
 * @property integer $c_status
 * @property string $c_special_id
 * @property string $c_category_id
 * @property string $c_hits
 * @property string $c_user_id
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Content extends _CommonModel {

    public $label;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_seo', 'c_keyword', 'c_description', 'c_source_url', 'c_sort', 'c_short', 'c_author', 'c_editor', 'c_source_site'], 'filter', 'filter' => 'trim'],
            ['c_special_id', 'default', 'value' => 0],
            /**
             * 自动生成规则
             */
            [['c_title', 'c_status', 'c_sort', 'c_category_id'], 'required'],
            [['c_create_type', 'c_source', 'c_status', 'c_special_id', 'c_category_id', 'c_hits', 'c_user_id', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time', 'label'], 'safe'],
            [['c_title', 'c_seo', 'c_keyword', 'c_description', 'c_source_url'], 'string', 'max' => 255],
            [['c_short', 'c_author', 'c_editor', 'c_source_site'], 'string', 'max' => 150],
            [['c_picture', 'c_file'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '标题',
            'c_short' => '短标题',
            'c_seo' => '标题优化',
            'c_keyword' => '关键词',
            'c_description' => '描述',
            'c_author' => '作者',
            'c_editor' => '编辑',
            'c_source_site' => '来源网站',
            'c_source_url' => '来源网址',
            'c_picture' => '缩略图',
            'c_file' => '附件',
            'c_create_type' => '来源类型', // 1PC 2H5 3IOS 4Andriod 8其他 9平台
            'c_source' => '来源类型', // 1原创 2转载 3翻译 4跳转
            'c_status' => '发布状态', // 1已发布 2已审核 3草稿
            'c_special_id' => '内容专题',
            'c_category_id' => '内容类别',
            'c_hits' => '点击总数',
            'c_user_id' => '用户',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
            'label' => '内容标签'
        ];
    }

    public function getContentCategory() {
        return $this->hasOne(ContentCategory::className(), ['c_id' => 'c_category_id']);
    }

    public function getContentSpecial() {
        return $this->hasOne(ContentSpecial::className(), ['c_id' => 'c_special_id']);
    }

    public function getContentLabel() {
        return $this->hasMany(ContentLabel::className(), ['c_content_id' => 'c_id']);
    }

    public function getContentText() {
        return $this->hasOne(ContentText::className(), ['c_content_id' => 'c_id']);
    }

    public static function getSource($type = null) {
        $array = [1 => '原创', 2 => '转贴', 3 => '翻译', 4 => '跳转'];
        return Util::getStatusText($type, $array);
    }

    public static function getStatus($type = null) {
        $array = [1 => '已发布', 2 => '已审核', 3 => '草稿'];
        return Util::getStatusText($type, $array);
    }

    public static function getLabel() {
        return [1 => '置顶', 2 => '推荐', 3 => '热门'];
    }

    public static function getLabelTitle($types) {
        $result = [];
        if ($types) {
            $label = self::getLabel();
            foreach ($types as $type) {
                if (isset($label[$type])) {
                    $result[] = $label[$type];
                }
            }
        }
        return $result;
    }

    public static function getLabelHtml($types) {
        $html = '';
        $data = self::getLabelTitle($types);
        if ($data) {
            foreach ($data as $v) {
                $html .= '<span class="label label-primary">' . $v . '</span> ';
            }
        }
        return $html;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            //图片处理
            $this->c_picture = Yii::$app->request->post('picture_list', '');
            //附件处理
            $this->c_file = Yii::$app->request->post('file_list', '');
            //自动设置描述
            $editor = Yii::$app->request->post('pc_content');
            if (empty($this->c_description) && $editor) {
                $this->c_description = String::msubstr(Util::filterStringRelace($editor), 0, 80);
            }
            if ($insert) {
                $this->c_editor = Yii::$app->user->identity->c_admin_name;
                $this->c_user_id = Yii::$app->user->id;
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
        Upload::updateFile($insert, $this->c_id);
        Upload::updateFile($insert, $this->c_id, Upload::UPLOAD_FILE);
        ContentText::addEdit($this->c_id, Yii::$app->request->post('pc_content'), Yii::$app->request->post('h5_content'), Yii::$app->request->post('app_content'));
        ContentLabel::addMore($this->c_id, $this->label);
        if ($insert) {
            ContentHits::add($this->c_id);
        }
    }

    /**
     * 删除之前处理相关数据
     */
    public function beforeDelete() {
        if (parent::beforeDelete()) {
            if ($this->c_picture) {
                Upload::deleteFile(explode(',', $this->c_picture), true);
            }
            if ($this->c_file) {
                Upload::deleteFile(explode(',', $this->c_file), true);
            }
            ContentHits::deleteAll(['c_content_id' => $this->c_id]);
            ContentText::deleteAll(['c_content_id' => $this->c_id]);
            ContentLabel::deleteAll(['c_content_id' => $this->c_id]);
            return true;
        }
        return false;
    }

}
