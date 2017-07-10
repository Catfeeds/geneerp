<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\Captcha;
use common\extensions\Util;
use common\models\User;

class FindPasswordForm extends Model {

    public $username;
    public $captcha;
    private $_user;

    public function rules() {
        return [
            [['username', 'captcha'], 'trim'],
            [['username', 'captcha'], 'required'],
            ['captcha', 'validateCaptcha'],
            ['username', 'validateUsername'],
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
            if (!Captcha::checkCaptcha($this->captcha)) {
                $this->addError($attribute, Yii::t('common', Common::CAPTCHA_CHECK_FAIL));
            }
        }
    }

    public function validateUsername($attribute) {
        if (!$this->hasErrors()) {
            $model = $this->getUser();
            if ($model) {
                if ($model->c_email_verify != 1 && $model->c_mobile_verify != 1) {
                    $this->addError($attribute, '手机与邮箱均未认证，无法找回密码');
                } else {
                    Yii::$app->session['find_password_user_id'] = $model->c_id;
                }
            } else {
                $this->addError($attribute, Yii::t('common', Common::ACCOUNTS_NOT_EXISTS));
            }
        }
    }

    private function getUser() {
        if ($this->_user === null) {
            if (strstr($this->username, '@') !== false) {
                $this->_user = User::findByEmail($this->username);
                return $this->_user;
            } elseif (Util::checkMobile($this->username)) {
                $this->_user = User::findByMobile($this->username);
                return $this->_user;
            } else {
                $this->_user = User::findByUsername($this->username);
                return $this->_user;
            }
        }
        return $this->_user;
    }

}
