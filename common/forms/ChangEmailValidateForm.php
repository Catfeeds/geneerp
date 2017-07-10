<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\CheckCode;
use common\models\User;
use common\models\NotityTemplate;

class ChangEmailValidateForm extends Model {

    public $email;
    public $email_captcha;

    public function rules() {
        return [
            [['email', 'email_captcha'], 'trim'],
            [['email', 'email_captcha'], 'required', 'message' => '{attribute}不能为空'],
            //验证新邮箱
            ['email', 'string', 'max' => 50, 'tooLong' => '{attribute}最多为{max}个字符'],
            ['email', 'email', 'message' => '{attribute}格式错误'],
            ['email', 'validateEmail', 'message' => '{attribute}已存在'],
            ['email_captcha', 'validateEmailCaptcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => '新邮箱',
            'email_captcha' => '新邮箱校验码',
        ];
    }

    public function validateEmail($attribute) {
        if (!$this->hasErrors()) {
            if (User::existEmail($this->email)) {
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

    public function changeEmail() {
        if ($this->validate()) {
            $model = Yii::$app->user->identity;
            $model->c_email = $this->email;
            $model->c_email_verify = User::STATUS_YES;
            $result = $model->save(false);
            if ($result) {
                NotityTemplate::sendNotify(NotityTemplate::NOTITY_CHANGE_EMAIL_SUCCESS, Yii::$app->user->getId());
                return true;
            }
        }
        return false;
    }

}
