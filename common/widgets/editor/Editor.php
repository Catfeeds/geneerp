<?php

namespace common\widgets\editor;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use common\widgets\editor\EditorAsset;
use common\extensions\CheckRule;

class Editor extends Widget {

    public $id = ''; //控件ID
    public $name = 'editor_content'; //控件name
    public $value = ''; //控件默认值
    public $object_id = 0; //关联ID
    public $height = '300px'; //editor高度
    public $upload_url = 'uploader/file'; //上传附件路由
    public $user_type = 1; //用户类型 1后台 2前台 前台需要再小部件写入 user_type=2

    public function run() {
        if ($this->name && empty($this->id)) {
            $this->id = $this->name;
        }

        $var['id'] = $this->id;
        $var['name'] = $this->name;
        $var['value'] = $this->value;
        $var['height'] = $this->height;
        $var['upload_url'] = $this->upload_url && ($this->user_type === 1 && CheckRule::checkRole($this->upload_url) || $this->user_type === 2) ? Url::to([$this->upload_url]) : false; //是否需要显示上传按钮
        $var['param'] = [Yii::$app->request->csrfParam => Yii::$app->request->csrfToken, 'object_id' => $this->object_id];

        EditorAsset::register($this->view);
        return $this->render('editor', $var);
    }

}
