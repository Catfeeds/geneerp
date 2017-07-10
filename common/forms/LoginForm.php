<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\Util;
use common\models\User;
use common\models\UserLoginLog;
use common\models\Upload;
use common\models\Areas;

class LoginForm extends Model {

    public $username;
    public $password;
    public $remember_me = false;

    /** create_type
      const CREATE_PC = 1; //PC
      const CREATE_H5 = 2; //H5
      const CREATE_IOS = 3; //IOS
      const CREATE_ANDRIOD = 4; //Andriod
      const CREATE_API = 7; //API
      const CREATE_OTHER = 8; //其他
      const CREATE_ADMIN = 9; //后台
     */
    public $create_type = 1;
    private $_user;

    public function rules() {
        return [
            [['username', 'password'], 'trim'],
            [['username', 'password', 'create_type'], 'required'],
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
            $data['c_status'] = User::STATUS_NO;
            $data['c_create_type'] = $this->create_type;
            $data['c_login_name'] = $this->username;
            $data['c_login_password'] = $this->password;
            $model = $this->getUser();
            if ($model) {
                if ($model->c_status == User::STATUS_NO) {
                    $this->addError($attribute, Yii::t('common', Common::USER_STATUS_ERROR));
                }
                if ($model->c_login_password == User::generatePassword($this->password, $model->c_login_random)) {
                    $data['c_status'] = User::STATUS_YES;
                    $data['c_login_password'] = '';
                } else {
                    $this->lockUser(); //判断是否锁定用户登录状态
                    $this->addError($attribute, Yii::t('common', Common::USER_PASSWORD_ERROR));
                }
            } else {
                $this->addError($attribute, Yii::t('common', Common::USER_PASSWORD_ERROR));
            }
            UserLoginLog::add($data);
        }
    }

    public function apiLogin() {
        if ($this->validate()) {
            if ($this->updateLogin()) {
                $area = Areas::getAreaTitle([$this->_user->userProfile->c_province_id, $this->_user->userProfile->c_city_id, $this->_user->userProfile->c_area_id]);
                return[
                    'token' => $this->_user->c_access_token,
                    'mobile' => $this->_user->c_mobile,
                    'username' => $this->_user->c_user_name,
                    'userhead' => $this->_user->userProfile->c_head ? Upload::getUploadUrl() . $this->_user->userProfile->c_head : '',
                    'userpoint' => $this->_user->userAcount->c_point,
                    'userregister' => date('Y-m-d', $this->_user->c_reg_date),
                    'userbirthday' => $this->_user->userProfile->c_birthday ? date('Y-m-d', $this->_user->userProfile->c_birthday) : '',
                    'userarea_id' => $this->_user->userProfile->c_province_id . ',' . $this->_user->userProfile->c_city_id . ',' . $this->_user->userProfile->c_area_id,
                    'userarea' => implode(' ', $area),
                    'usersign' => $this->_user->userProfile->c_sign
                ];
            }
        }
        return false;
    }

    public function login() {
        if ($this->validate()) {
            $this->updateLogin();
            return Yii::$app->user->login($this->_user, $this->remember_me ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    private function updateLogin() {
        if ($this->create_type == User::CREATE_API && User::apiTokenIsValid($this->_user->c_access_token) === false) {
            $this->_user->generateApiToken();
        }
        $this->_user->c_last_login_time = time();
        $this->_user->c_last_ip = ip2long(Yii::$app->getRequest()->getUserIP());
        $this->_user->c_login_total = $this->_user->c_login_total + 1;
        return $this->_user->save(false);
    }

    protected function getUser() {
        if ($this->_user === null) {
            if (strstr($this->username, '@') !== false) {
                $this->_user = User::existEmail($this->username);
            } elseif (Util::checkMobile($this->username)) {
                $this->_user = User::existMobile($this->username);
            } else {
                $this->_user = User::existUsername($this->username);
            }
        }

        return $this->_user;
    }

    private function lockUser() {
        $cache_name = 'user_login_max_count';
        $count = (int) User::getCache($cache_name);
        if ($count >= Yii::$app->params[$cache_name]) {
            $model = $this->getUser();
            $model->c_status = User::STATUS_NO;
            if ($model->save(false)) {
                User::setCache($cache_name, 0);
            }
        } else {
            User::setCache($cache_name, $count + 1);
        }
    }

}
