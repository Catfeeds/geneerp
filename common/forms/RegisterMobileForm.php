<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\extensions\CheckCode;
use common\models\User;
use common\models\NotityTemplate;
use common\models\Areas;

class RegisterMobileForm extends Model {

    public $mobile;
    public $password;
    public $sms_captcha;
    public $invite_code;
    public $create_type;
    private $_user;

    public function rules() {
        return [
            [['mobile', 'password', 'sms_captcha'], 'trim'],
            [['mobile', 'password', 'sms_captcha', 'create_type'], 'required'],
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
            'invite_code' => '注册邀请码',
        ];
    }

    public function validateMobile($attribute) {
        if (!$this->hasErrors()) {
            if ($this->getUser()) {
                $this->addError($attribute, Yii::t('common', Common::MOBILE_EXISTS));
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

    public function register($return_obj = false) {
        if ($this->validate()) {
            $model = new User();
            $model->c_mobile = $this->mobile;
            $model->c_mobile_verify = User::STATUS_YES;
            $model->generateUsername($this->mobile);
            $model->settingLoginPassword($this->password);
            $model->c_create_type = $this->create_type;
            $model->c_reg_date = strtotime(date('Y-m-d'));
            $model->c_reg_ip = ip2long(Yii::$app->getRequest()->getUserIP());
            $model->c_last_login_time = time();
            $model->c_create_time = time();
            $result = $model->save();
            if ($result) {
                //若为设置模板信息则不会发送
                NotityTemplate::sendNotify(NotityTemplate::NOTITY_REGISTER_SUCCESS, $model->c_id);
                if ($return_obj) {
                    return $model;
                }
                $user = $this->getUser();
                $area = Areas::getAreaTitle([$user->userProfile->c_province_id, $user->userProfile->c_city_id, $user->userProfile->c_area_id]);
                return[
                    'token' => $user->c_access_token,
                    'mobile' => $user->c_mobile,
                    'username' => $user->c_user_name,
                    //'userhead' => $user->userProfile->c_head ? Upload::getUploadUrl() . $user->userProfile->c_head : '',
                    'userpoint' => $user->userAcount->c_point,
                    'userregister' => date('Y-m-d', $user->c_reg_date),
                    'userbirthday' => $user->userProfile->c_birthday ? date('Y-m-d', $user->userProfile->c_birthday) : '',
                    'userarea_id' => $user->userProfile->c_province_id . ',' . $user->userProfile->c_city_id . ',' . $user->userProfile->c_area_id,
                    'userarea' => implode(' ', $area),
                    'usersign' => $user->userProfile->c_sign
                ];
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
