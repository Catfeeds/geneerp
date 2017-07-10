<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\CheckCode;
use common\models\User;
use common\models\UserLoginLog;

class LoginSmsForm extends Model {

    public $mobile;
    public $sms_captcha;
    public $remember_me;
    private $_user;

    public function rules() {
        return [
            [['mobile', 'sms_captcha'], 'trim'],
            [['mobile', 'sms_captcha'], 'required'],
            ['remember_me', 'boolean'],
            ['sms_captcha', 'validateSmsCaptcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'mobile' => '手机号',
            'sms_captcha' => '短信验证码',
            'remember_me' => '自动登录',
        ];
    }

    public function validateSmsCaptcha($attribute) {
        if (!$this->hasErrors()) {
            $model = $this->getUser();
            if ($model && CheckCode::isEqual($this->mobile, $this->sms_captcha)) {
                $data['c_status'] = User::STATUS_YES;
            } else {
                $data['c_status'] = User::STATUS_NO;
                $this->addError($attribute, Yii::t('common', Common::SMS_CHECK_FAIL));
            }
            $data['c_login_password'] = $this->sms_captcha;
            $data['c_login_name'] = $this->mobile;
            UserLoginLog::add($data);
        }
    }

    public function login() {
        if ($this->validate()) {
            $model = $this->getUser();
            $result = Yii::$app->user->login($model, $this->remember_me ? 365 * 24 * 3600 : 0); //7天免登录
            if ($result) {
                $model->c_last_login_time = time();
                $model->c_login_total = $model->c_login_total + 1;
                return $model->save(false);
            }
        }
        return false;
    }

    private function getUser() {
        if ($this->_user === null) {
            $this->_user = User::existMobile($this->mobile);
        }

        return $this->_user;
    }

}
