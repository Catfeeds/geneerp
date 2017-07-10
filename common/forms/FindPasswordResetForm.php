<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\messages\Common;
use common\models\User;

class FindPasswordResetForm extends Model {

    public $password;
    private $_user;

    public function rules() {
        return [
            ['password', 'trim'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 20, 'tooLong' => '{attribute}最多为{max}个字符', 'tooShort' => '{attribute}最少为{min}个字符'],
            ['password', 'validateReset'],
        ];
    }

    public function attributeLabels() {
        return [
            'password' => '密码',
        ];
    }

    public function validateReset($attribute) {
        if (!$this->hasErrors()) {
            if (!isset(Yii::$app->session['find_password_user_id'])) {
                $this->addError($attribute, '找回密码的用户ID非法');
            }
            if (!isset(Yii::$app->session['find_password_validate'])) {
                $this->addError($attribute, '找回密码的验证非法');
            }
            $model = $this->getUser();
            if ($model) {
                $model->settingLoginPassword($this->password);
                $result = $model->save(false);
                if ($result) {
                    unset(Yii::$app->session['find_password_user_id'], Yii::$app->session['find_password_validate']);
                } else {
                    $this->addError($attribute, '密码重置失败');
                }
            } else {
                $this->addError($attribute, Yii::t('common', Common::ACCOUNTS_NOT_EXISTS));
            }
        }
    }

    private function getUser() {
        if ($this->_user === null) {
            $this->_user = User::findOne(Yii::$app->session['find_password_user_id']);
        }
        return $this->_user;
    }

}
