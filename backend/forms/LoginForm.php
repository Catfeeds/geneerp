<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\Util;
use backend\models\Admin;
use backend\models\AdminLoginLog;

class LoginForm extends Model {

    public $username;
    public $password;
    public $remember_me = false;
    private $_user;

    public function rules() {
        return [
            [['username', 'password'], 'trim'],
            [['username', 'password'], 'required'],
            ['remember_me', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => '账号',
            'password' => '密码',
            'remember_me' => '24小时免登录'
        ];
    }

    public function validatePassword($attribute) {
        if (!$this->hasErrors()) {
            $data['c_status'] = Admin::STATUS_NO;
            $data['c_login_name'] = $this->username;
            $data['c_login_password'] = $this->password;
            $model = $this->getUser();
            if ($model) {
                if ($model->c_status == Admin::STATUS_NO) {
                    $this->addError($attribute, Yii::t('common', Common::ADMIN_STATUS_ERROR));
                }
                if ($model->c_password == Admin::generatePassword($this->password, $model->c_login_random)) {
                    $data['c_status'] = Admin::STATUS_YES;
                    $data['c_login_password'] = '';
                } else {
                    $this->lockUser(); //判断是否锁定用户登录状态
                    $this->addError($attribute, Yii::t('common', Common::USER_PASSWORD_ERROR));
                }
            } else {
                $this->addError($attribute, Yii::t('common', Common::USER_PASSWORD_ERROR));
            }
            AdminLoginLog::add($data);
        }
    }

    public function login() {
        if ($this->validate()) {
            $model = $this->_user;
            $model->c_last_login_time = time();
            $model->c_last_ip = ip2long(Yii::$app->getRequest()->getUserIP());
            $model->c_login_total = $model->c_login_total + 1;
            $model->save(false);
            return Yii::$app->user->login($model, $this->remember_me ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    protected function getUser() {
        if ($this->_user === null) {
            if (strstr($this->username, '@') !== false) {
                $this->_user = Admin::existEmail($this->username);
            } elseif (Util::checkMobile($this->username)) {
                $this->_user = Admin::existMobile($this->username);
            } else {
                $this->_user = Admin::existAdminName($this->username);
            }
        }

        return $this->_user;
    }

    private function lockUser() {
        $cache_name = 'admin_login_max_count';
        $count = (int) Admin::getCache($cache_name);
        if ($count >= Yii::$app->params[$cache_name]) {
            $model = $this->getUser();
            $model->c_status = Admin::STATUS_NO;
            if ($model->save(false)) {
                Admin::setCache($cache_name, 0);
            }
        } else {
            Admin::setCache($cache_name, $count + 1);
        }
    }

}
