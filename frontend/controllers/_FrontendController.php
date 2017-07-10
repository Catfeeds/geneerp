<?php

namespace frontend\controllers;

use Yii;
use common\controllers\_CommonController;
use common\models\UserOperationLog;

class _FrontendController extends _CommonController {

    public $title;

    //母版类型
    //简单导航（常用于注册登录）
    const SIMPLE_LAYOUT = 3;
    //用户中心
    const UCENTER_LAYOUT = 4;

    //模板名称
    public $template;

    public function init() {
        parent::init();
        if (Yii::$app->params['system_site_open'] === '2') {
            self::alert(Yii::$app->params['system_site_close_msg']);
        }
        $this->template = isset(Yii::$app->params['system_template']) && Yii::$app->params['system_template'] ? Yii::$app->params['system_template'] : 'default';
        $this->layout = '@app/views/' . $this->template . '/layouts/nav.php';
        $this->setViewPath('@app/views/' . $this->template . '/' . $this->id);
    }

    public function setLayout($type = self::MAIN_LAYOUT) {
        if (self::MAIN_LAYOUT == $type) {
            $this->layout = '@app/views/' . $this->template . '/layouts/main.php';
        } elseif (self::NAV_LAYOUT == $type) {
            $this->layout = '@app/views/' . $this->template . '/layouts/nav.php';
        } elseif (self::SIMPLE_LAYOUT == $type) {
            $this->layout = '@app/views/' . $this->template . '/layouts/simple.php';
        } elseif (self::UCENTER_LAYOUT == $type) {
            $this->layout = '@app/views/' . $this->template . '/layouts/user.php';
        }
    }

    /**
     *  加入操作日志
     * @param type $type 操作类型 1新增 2编辑 3删除
     * @param type $id 操作对象的ID
     * @param type $status 操作结果状态 1成功 2失败
     * @param type $data 操作数据
     */
    protected function log($type, $id, $status, $data = '') {
        if (isset(Yii::$app->params['user_log_status']) && Yii::$app->params['user_log_status'] === '1') {
            $log['c_route'] = Yii::$app->controller->getRoute();
            $log['c_object_id'] = (int) $id;
            $log['c_status'] = $status ? 1 : 2;
            $log['c_type'] = $type;
            if ($data) {
                $log['c_note'] = serialize($data);
            }
            UserOperationLog::add($log);
        }
    }

}
