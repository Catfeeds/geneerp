<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;
use common\messages\Common;
use common\extensions\Util;
use common\extensions\String;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $c_id
 * @property string $c_login_random
 * @property string $c_pay_random
 * @property string $c_mobile
 * @property string $c_login_password
 * @property string $c_pay_password
 * @property string $c_auth_key
 * @property string $c_access_token
 * @property string $c_user_name
 * @property string $c_email
 * @property integer $c_group_id
 * @property integer $c_mobile_verify
 * @property integer $c_email_verify
 * @property integer $c_status
 * @property integer $c_create_type
 * @property string $c_login_total
 * @property string $c_last_login_time
 * @property string $c_reg_date
 * @property integer $c_reg_ip
 * @property integer $c_last_ip
 * @property string $c_create_time
 * @property string $c_update_time
 */
class User extends _CommonModel implements IdentityInterface {

    const VERIFY_YES = 1; //已验证
    const VERIFY_NO = 2; //未绑定
    const VERIFY_WAIT = 3; //待验证

    public $old_password;
    public $new_password;
    public $confirm_password;
    public $old_pay_password;
    public $new_pay_password;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_user_name', 'old_password', 'new_password', 'confirm_password', 'c_mobile', 'c_email'], 'trim'],
            [['c_group_id', 'c_mobile_verify', 'c_email_verify', 'c_status', 'c_create_type', 'c_login_total', 'c_last_login_time', 'c_reg_date', 'c_reg_ip', 'c_last_ip', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_login_random', 'c_pay_random'], 'string', 'max' => 4],
            [['c_login_password', 'c_pay_password', 'c_auth_key'], 'string', 'max' => 32],
            ['c_access_token', 'string', 'max' => 43],
            //用户名
            ['c_user_name', 'string', 'length' => [3, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符'],
            ['c_user_name', 'unique', 'message' => '{attribute}已存在', 'on' => ['create']],
            //手机号
            ['c_mobile', 'match', 'skipOnEmpty' => true, 'pattern' => '/^1[3578][0-9]{9}$/', 'message' => '{attribute}格式错误'],
            ['c_mobile', 'unique', 'skipOnEmpty' => true, 'message' => '{attribute}已存在'],
            //邮箱
            ['c_email', 'string', 'max' => 50, 'tooLong' => '{attribute}最多为{max}个字符'],
            ['c_email', 'email', 'skipOnEmpty' => true, 'message' => '{attribute}格式错误'],
            ['c_email', 'unique', 'skipOnEmpty' => true, 'message' => '{attribute}已存在'],
            //新密码
            ['new_password', 'string', 'length' => [6, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符', 'on' => ['create', 'update-password', 'user-setting-password']],
            //新支付密码
            ['new_pay_password', 'string', 'length' => [6, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符', 'on' => ['user-setting-pay-password', 'user-change-pay-password']],
            //用户使用 原支付密码
            ['old_pay_password', 'string', 'length' => [6, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符', 'on' => ['user-change-pay-password']],
            ['old_pay_password', 'validatePayPassword', 'on' => ['user-change-pay-password']],
            //用户使用 原密码
            ['old_password', 'string', 'length' => [6, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符', 'on' => ['user-setting-password', 'user-change-password', 'user-validate-password']],
            ['old_password', 'validateLoginPassword', 'on' => ['user-setting-password', 'user-change-password', 'user-validate-password']],
            //确认密码
            ['confirm_password', 'string', 'length' => [6, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符', 'on' => ['create', 'update-password']],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => '两次密码不一致', 'on' => ['create', 'update-password']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_login_random' => '登录秘密随机字符串',
            'c_pay_random' => '支付秘密随机字符串',
            'c_mobile' => '手机号',
            'c_login_password' => '登录密码',
            'c_pay_password' => '支付密码',
            'c_auth_key' => 'cookie用户认证',
            'c_access_token' => 'api 通过access_token参数登录',
            'c_user_name' => '用户名',
            'c_email' => '邮箱',
            'c_group_id' => '用户组ID',
            'c_mobile_verify' => '手机验证', // 1已验证 2未绑定 3待验证
            'c_email_verify' => '邮箱验证', // 1已验证 2未绑定 3待验证
            'c_status' => '用户登录状态', // 1正常 2无效
            'c_create_type' => '来源类型', // 1PC 2H5 3IOS 4Andriod 8其他 9平台
            'c_login_total' => '登录次数',
            'c_last_login_time' => '最后登录时间',
            'c_reg_date' => '注册日期',
            'c_reg_ip' => '注册IP',
            'c_last_ip' => '最后登录IP',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
            'old_password' => '原密码',
            'new_password' => '新密码',
            'confirm_password' => '确认密码',
            'old_pay_password' => '原支付密码',
            'new_pay_password' => '新支付密码',
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['c_user_name', 'new_password', 'confirm_password', 'c_login_random', 'c_auth_key', 'c_access_token', 'c_mobile', 'c_email', 'c_mobile_verify', 'c_email_verify', 'c_group_id', 'c_status', 'c_reg_date', 'c_create_time'];
        $scenarios['update'] = ['c_mobile', 'c_email', 'c_group_id', 'c_status'];
        $scenarios['update-password'] = ['new_password', 'confirm_password'];
        $scenarios['user-setting-password'] = ['new_password'];
        $scenarios['user-change-password'] = ['old_password', 'new_password'];
        $scenarios['user-setting-pay-password'] = ['old_password', 'new_pay_password'];
        $scenarios['user-change-pay-password'] = ['old_pay_password', 'new_pay_password'];
        $scenarios['user-validate-password'] = ['old_password'];
        return $scenarios;
    }

    public function validateLoginPassword($attribute) {
        if (!$this->hasErrors()) {
            if ($this->c_login_password != self::generatePassword($this->old_password, $this->c_login_random)) {
                $this->addError($attribute, Yii::t('common', Common::PASSWORD_OLD_CHECK_FAIL));
            }
        }
    }

    public function validatePayPassword($attribute) {
        if (!$this->hasErrors()) {
            if ($this->c_pay_password != self::generatePassword($this->old_pay_password, $this->c_pay_random)) {
                $this->addError($attribute, '原支付密码验证失败');
            }
        }
    }

    public function getUserGroup() {
        return $this->hasOne(UserGroup::className(), ['c_id' => 'c_group_id']);
    }

    public function getUserAcount() {
        return $this->hasOne(UserAcount::className(), ['c_user_id' => 'c_id']);
    }

    public function getUserProfile() {
        return $this->hasOne(UserProfile::className(), ['c_user_id' => 'c_id']);
    }

    /**
     * 获取验证状态
     * @param type $type
     * @return type
     */
    public static function getVerifyStatusText($type = null) {
        $array = [
            self::VERIFY_YES => '已验证',
            self::VERIFY_NO => '未绑定',
            self::VERIFY_WAIT => '待验证'
        ];
        return Util::getStatusText($type, $array);
    }

    /**
     * 获取验证状态
     * @param type $type
     * @return type
     */
    public static function getVerifyStatus($type = null) {
        $array = [
            self::VERIFY_YES => ['已验证', 'ok-sign', 'text-success'],
            self::VERIFY_NO => ['未绑定', 'ban-circle', 'text-danger'],
            self::VERIFY_WAIT => ['待验证', 'question-sign', 'text-primary']
        ];
        return Util::getStatusIcon($type, $array);
    }

    public function getId() {
        return $this->c_id;
    }

    public function getAuthKey() {
        return $this->c_auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->c_auth_key === $authKey;
    }

    public function generateUsername($name) {
        $this->c_user_name = self::createUsername($name);
    }

    //创建用户名
    public static function createUsername($name) {
        $_name = $name;
        $prefix = isset(Yii::$app->params['username_prefix']) && Yii::$app->params['username_prefix'] ? Yii::$app->params['username_prefix'] : 'JJ';
        $temp = strstr($name, '@', true);
        if ($temp === false) {
            $name = $prefix . substr($name, 0, 3) . substr($name, -4); //非邮箱注册 JJ 前3位 + 后4位
        } else {
            $name = $prefix . substr($temp, 0, 7); //邮箱注册，JJ + 取@前字符串前7位
        }
        if (self::existUsername($name)) {//如果存在 增加后缀随机4位数字
            $suffix = String::randString(4, 1);
            return self::createUsername($_name . $suffix);
        }
        return $name;
    }

    /**
     * 设置登录密码
     * @return boolean
     */
    public function updateLoginPassword() {
        if ($this->validate()) {
            $this->settingLoginPassword($this->new_password);
            return $this->save(false); //取消第二次验证
        }
        return false;
    }

    /**
     * 设置支付密码
     * @return boolean
     */
    public function updatePayPassword() {
        if ($this->validate()) {
            $random_str = Yii::$app->security->generateRandomString(4);
            $this->c_pay_random = $random_str;
            $this->c_pay_password = self::generatePassword($this->new_pay_password, $random_str);
            return $this->save(false); //取消第二次验证
        }
        return false;
    }

    /**
     * 关闭支付密码
     * @return boolean
     */
    public function closePayPassword() {
        if ($this->validate()) {
            $this->c_pay_random = '';
            $this->c_pay_password = '';
            return $this->save(false); //取消第二次验证
        }
        return false;
    }

    /**
     * 填充密码
     * @param type $password
     */
    public function settingLoginPassword($password) {
        $this->generateApiToken();
        $random_str = Yii::$app->security->generateRandomString(4);
        $this->c_login_random = $random_str;
        $this->c_login_password = self::generatePassword($password, $random_str);
    }

    /**
     * 填充支付密码
     * @param type $password
     */
    public function settingPayPassword($password) {
        $random_str = Yii::$app->security->generateRandomString(4);
        $this->c_pay_random = $random_str;
        $this->c_pay_password = self::generatePassword($password, $random_str);
    }

    /**
     * 检测密码
     * @param type $password
     * @param type $random_str
     * @return type
     */
    public static function generatePassword($password, $random_str) {
        return md5(md5($password) . $random_str);
    }

    public static function findIdentity($id) {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        //如果token无效的话，
        if (static::apiTokenIsValid($token)) {
            return User::findOne(['c_access_token' => $token, 'c_status' => self::STATUS_YES]);
        } else {
            throw new \yii\web\UnauthorizedHttpException('token is invalid.');
        }
    }

    public static function findByUsername($username) {
        return User::findOne(['c_user_name' => $username, 'c_status' => self::STATUS_YES]);
    }

    public static function findByMobile($mobile) {
        return User::findOne(['c_mobile' => $mobile, 'c_mobile_verify' => self::STATUS_YES, 'c_status' => self::STATUS_YES]);
    }

    public static function findByEmail($email) {
        return User::findOne(['c_email' => $email, 'c_email_verify' => self::STATUS_YES, 'c_status' => self::STATUS_YES]);
    }

    public static function existUsername($username) {
        return User::findOne(['c_user_name' => $username]);
    }

    public static function existMobile($mobile) {
        return User::findOne(['c_mobile' => $mobile]);
    }

    public static function existEmail($email) {
        return User::findOne(['c_email' => $email]);
    }

    /**
     * 这个就是我们进行yii\filters\auth\QueryParamAuth调用认证的函数
     * @param type $token
     * @param type $type
     * @return type
     */
    public function loginByAccessToken($token, $type) {
        return User::findIdentityByAccessToken($token, $type); //查询数据库中有没有存在这个token  
    }

    /**
     * 生成 api_token
     */
    public function generateApiToken() {
        $this->c_access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * 校验api_token是否有效
     */
    public static function apiTokenIsValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['api_token_expire'];
        return $timestamp + $expire >= time();
    }

    public static function getUserLevel() {
        $level = Util::securityLevel(Yii::$app->user->identity->c_login_password, Yii::$app->user->identity->c_pay_password, Yii::$app->user->identity->c_mobile_verify, Yii::$app->user->identity->c_email_verify);
        $level_str = '中';
        if ($level === 4) {
            $level_str = '高';
        } elseif ($level < 2) {
            $level_str = '低';
        }
        $var['level'] = $level;
        $var['level_str'] = $level_str;
        return $var;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (in_array($this->scenario, ['create', 'update'])) {
                if ($this->c_email) {
                    if ($this->c_email_verify == self::VERIFY_NO) {
                        $this->c_email_verify = self::VERIFY_WAIT;
                    }
                } else {
                    $this->c_email_verify = self::VERIFY_NO;
                }
                if ($this->c_mobile) {
                    if ($this->c_mobile_verify == self::VERIFY_NO) {
                        $this->c_mobile_verify = self::VERIFY_WAIT;
                    }
                } else {
                    $this->c_mobile_verify = self::VERIFY_NO;
                }
            }
            if ($this->scenario == 'create') {
                $this->c_create_type = self::CREATE_ADMIN; //后台创建用户
                $this->c_reg_date = strtotime(date('Y-m-d'));
                $this->c_reg_ip = ip2long(Yii::$app->getRequest()->getUserIP());
                $this->c_last_login_time = time();
                $this->c_create_time = time();
                $this->generateApiToken();
                $this->settingLoginPassword($this->new_password);
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            UserAcount::addUserAcount($this->c_id);
            UserProfile::addUserProfile($this->c_id);
        }
    }

}
