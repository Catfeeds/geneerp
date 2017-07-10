<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\CheckCode;
use common\models\User;
use common\models\NotityTemplate;

class RegisterEmailForm extends Model {

    public $email;
    public $password;
    public $email_captcha;
    public $invite_code;
    public $soure_type;
    private $_user;

    public function rules() {
        return [
            [['email', 'password', 'email_captcha'], 'trim'],
            [['email', 'password', 'email_captcha', 'soure_type'], 'required'],
            ['email', 'email', 'message' => '{attribute}格式错误'],
            ['email', 'string', 'max' => 50, 'tooLong' => '{attribute}最多为{max}个字符'],
            ['email', 'validateEmail'],
            ['password', 'string', 'min' => 6, 'max' => 20, 'tooLong' => '{attribute}最多为{max}个字符', 'tooShort' => '{attribute}最少为{min}个字符'],
            ['email_captcha', 'validateEmailCaptcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => '邮箱',
            'password' => '密码',
            'email_captcha' => '邮箱校验码',
            'invite_code' => '注册邀请码',
        ];
    }

    public function validateEmail($attribute) {
        if (!$this->hasErrors()) {
            if ($this->getUser()) {
                $this->addError($attribute, Yii::t('common', Common::EMAIL_EXISTS));
            }
        }
    }

    public function validateEmailCaptcha($attribute) {
        if (!$this->hasErrors()) {
            if (!CheckCode::isEqual($this->email, $this->email_captcha)) {
                $this->addError($attribute, Yii::t('common', Common::EMAIL_CODE_CHECK_FAIL));
            }
        }
    }

    public function register() {
        if ($this->validate()) {
            $model = new User();
            $model->c_email = $this->email;
            $model->c_email_verify = User::STATUS_YES;
            $model->generateUsername($this->email);
            $model->settingLoginPassword($this->password);
            $model->c_create_type = $this->create_type;
            $model->c_reg_date = strtotime(date('Y-m-d'));
            $model->c_reg_ip = ip2long(Yii::$app->getRequest()->getUserIP());
            $model->c_create_time = time();
            $model->c_last_login_time = time();
            $result = $model->save();
            if ($result) {
                //若为设置模板信息则不会发送
                NotityTemplate::sendNotify(NotityTemplate::NOTITY_REGISTER_SUCCESS, $model->c_id);
                return $model;
            }
        }
        return null;
    }

    private function getUser() {
        if ($this->_user === null) {
            $this->_user = User::existEmail($this->email);
        }

        return $this->_user;
    }

}
