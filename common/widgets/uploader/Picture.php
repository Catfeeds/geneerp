<?php

namespace common\widgets\uploader;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use common\extensions\CheckRule;

class Picture extends Widget {

    public $name = 'picture_list';
    public $value = ''; //控件默认值
    public $object_id = 0; //关联ID
    public $upload_url = 'uploader/picture'; //上传附件路由
    public $delete_url = 'uploader/delete'; //删除附件路由
    public $user_type = 1; //用户类型 1后台 2前台 前台需要再小部件写入 user_type=2

    public function run() {
        $var['name'] = $this->name;
        $var['value'] = $this->value;
        $var['upload_url'] = $this->upload_url && ($this->user_type === 1 && CheckRule::checkRole($this->upload_url) || $this->user_type === 2) ? Url::to([$this->upload_url]) : false; //是否需要显示上传按钮
        $var['delete_url'] = $this->delete_url && ($this->user_type === 1 && CheckRule::checkRole($this->delete_url) || $this->user_type === 2) ? Url::to([$this->delete_url]) : false; //是否需要显示删除按钮
        $var['param'] = [Yii::$app->request->csrfParam => Yii::$app->request->csrfToken, 'object_id' => $this->object_id]; //POST提交参数
        return $this->render('picture', $var);
    }

}
