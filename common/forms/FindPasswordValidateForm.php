<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\CheckCode;
use common\extensions\Util;

class FindPasswordValidateForm extends Model {

    public $username;
    public $captcha;

    public function rules() {
        return [
            [['username', 'captcha'], 'trim'],
            [['username', 'captcha'], 'required'],
            ['captcha', 'validateCaptcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => '账号',
            'captcha' => '验证码',
        ];
    }

    public function validateCaptcha($attribute) {
        if (!$this->hasErrors()) {
            if (Util::checkEmail($this->username)) {
                $this->validateEmailCaptcha($attribute);
            } elseif (Util::checkMobile($this->username)) {
                $this->validateSmsCaptcha($attribute);
            } else {
                $this->addError($attribute, Yii::t('common', Common::ACCOUNTS_NOT_EXISTS));
            }
        }
    }

    private function validateEmailCaptcha($attribute) {
        if (CheckCode::isEqual($this->username, $this->captcha)) {
            Yii::$app->session['find_password_validate'] = true;
        } else {
            $this->addError($attribute, Yii::t('common', Common::EMAIL_CODE_CHECK_FAIL));
        }
    }

    private function validateSmsCaptcha($attribute) {
        if (CheckCode::isEqual($this->username, $this->captcha)) {
            Yii::$app->session['find_password_validate'] = true;
        } else {
            $this->addError($attribute, Yii::t('common', Common::SMS_CHECK_FAIL));
        }
    }

}
