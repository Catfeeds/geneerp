<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\CheckCode;
use common\models\User;
use common\models\NotityTemplate;

class ChangMobileValidateForm extends Model {

    public $mobile;
    public $sms_captcha;

    public function rules() {
        return [
            [['mobile', 'sms_captcha'], 'trim'],
            [['mobile', 'sms_captcha'], 'required'],
            ['mobile', 'match', 'pattern' => '/^1[3578][0-9]{9}$/', 'message' => '{attribute}格式错误'],
            ['mobile', 'validateMobile'],
            ['sms_captcha', 'validateSmsCaptcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'mobile' => '新手机',
            'sms_captcha' => '新手机验证码',
        ];
    }

    public function validateMobile($attribute) {
        if (!$this->hasErrors()) {
            if (User::existMobile($this->mobile)) {
                $this->addError($attribute, Yii::t('common', Common::MOBILE_EXISTS));
            }
        }
    }

    public function validateSmsCaptcha($attribute) {
        if (!$this->hasErrors()) {
            if (!CheckCode::isEqual($this->mobile, $this->sms_captcha)) {
                $this->addError($attribute, Yii::t('common', Common::SMS_CHECK_FAIL));
            }
        }
    }

    public function changeMobile() {
        if ($this->validate()) {
            $model = Yii::$app->user->identity;
            $model->c_mobile = $this->mobile;
            $model->c_mobile_verify = User::STATUS_YES;
            $result = $model->save(false);
            if ($result) {
                NotityTemplate::sendNotify(NotityTemplate::NOTITY_CHANGE_MOBILE_SUCCESS, Yii::$app->user->getId());
                return true;
            }
        }
        return false;
    }

}
