<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\models\AdminLoginLog;
use backend\models\Admin;

class AdminLoginForm extends Model {

    public $username;
    public $password;
    public $remember_me = false;
    public $is_api = false;
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
            'remember_me' => '自动登录',
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
                    $this->addError($attribute, Yii::t('common', Common::ACCOUNTS_STATUS_ERROR));
                }
                if ($model->c_password == Admin::generatePassword($this->password, $model->c_login_random)) {
                    $data['c_status'] = Admin::STATUS_YES;
                    $data['c_login_password'] = '';
                } else {
                    $this->lockUser(); //锁定账号登录状态
                    $this->addError($attribute, Yii::t('common', Common::ACCOUNTS_PASSWORD_ERROR));
                }
            } else {
                $this->addError($attribute, Yii::t('common', Common::ACCOUNTS_PASSWORD_ERROR));
            }
            AdminLoginLog::add($data);
        }
    }

    public function login() {
        if ($this->validate() && $this->updateLogin()) {
            return Yii::$app->user->login($this->_user, $this->remember_me ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    public function apiLogin() {
        if ($this->validate() && $this->updateLogin()) {
            return [
                'name' => $this->_user->c_admin_name,
                'token' => $this->_user->c_access_token,
            ];
        }
        return false;
    }

    private function updateLogin() {
        if ($this->is_api && Admin::apiTokenIsValid($this->_user->c_access_token) === false) {
            $this->_user->generateApiToken();
        }
        $this->_user->c_last_login_time = time();
        $this->_user->c_last_ip = ip2long(Yii::$app->getRequest()->getUserIP());
        $this->_user->c_login_total = $this->_user->c_login_total + 1;
        return $this->_user->save();
    }

    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = Admin::existAdminName($this->username);
        }

        return $this->_user;
    }

    /**
     * 锁定登录账号
     */
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
