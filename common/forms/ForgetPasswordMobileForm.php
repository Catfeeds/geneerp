<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\CheckCode;
use common\models\User;
use common\models\NotityTemplate;

class ForgetPasswordMobileForm extends Model {

    public $mobile;
    public $password;
    public $sms_captcha;
    private $_user;

    public function rules() {
        return [
            [['mobile', 'password', 'sms_captcha'], 'trim'],
            [['mobile', 'password', 'sms_captcha'], 'required'],
            ['mobile', 'match', 'pattern' => '/^1[3578][0-9]{9}$/', 'message' => '{attribute}格式错误'],
            ['mobile', 'validateMobile'],
            ['password', 'string', 'min' => 6, 'max' => 20, 'tooLong' => '{attribute}最多为{max}个字符', 'tooShort' => '{attribute}最少为{min}个字符'],
            ['sms_captcha', 'validateSmsCaptcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'mobile' => '手机号',
            'password' => '密码',
            'sms_captcha' => '短信验证码',
        ];
    }

    public function validateMobile($attribute) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user) {
                if ($user->c_status == User::STATUS_NO) {
                    $this->addError($attribute, Yii::t('common', Common::USER_STATUS_ERROR));
                }
            } else {
                $this->addError($attribute, Yii::t('common', Common::MOBILE_NOT_EXISTS));
            }
        }
    }

    public function validateSmsCaptcha($attribute) {
        if (!$this->hasErrors()) {
            if (!CheckCode::isEqual($this->mobile, $this->sms_captcha)) {
                $this->addError($attribute, Yii::t('common', Common::SMS_CODE_CHECK_FAIL));
            }
        }
    }

    public function setPassword() {
        if ($this->validate()) {
            $model = $this->getUser();
            $model->settingLoginPassword($this->password);
            if ($model->save(false)) {
                //若为设置模板信息则不会发送
                NotityTemplate::sendNotify(NotityTemplate::NOTITY_CHANGE_MOBILE_SUCCESS, $model->c_id);
                return true;
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
