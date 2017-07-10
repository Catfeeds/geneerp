<?php

namespace backend\models;

use Yii;
use common\models\_CommonModel;
use common\messages\Common;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property string $c_id
 * @property string $c_login_random
 * @property string $c_mobile
 * @property string $c_password
 * @property string $c_auth_key
 * @property string $c_access_token
 * @property string $c_admin_name
 * @property string $c_email
 * @property integer $c_status
 * @property string $c_role_id
 * @property string $c_login_total
 * @property string $c_last_login_time
 * @property integer $c_last_ip
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Admin extends _CommonModel implements IdentityInterface {

    public $old_password;
    public $new_password;
    public $confirm_password;
    private $_role;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 默认值
             */
            ['c_role_id', 'default', 'value' => 0],
            ['c_status', 'default', 'value' => self::STATUS_NO],
            /**
             * 过滤左右空格
             */
            [['c_admin_name', 'old_password', 'new_password', 'confirm_password', 'c_mobile', 'c_email'], 'filter', 'filter' => 'trim'],
            /**
             * 用户名
             */
            ['c_admin_name', 'required', 'message' => '{attribute}不能为空'],
            ['c_admin_name', 'string', 'length' => [3, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符'],
            ['c_admin_name', 'unique', 'message' => '{attribute}已存在'],
            /**
             * 手机
             */
            ['c_mobile', 'string', 'max' => 11],
            ['c_mobile', 'match', 'skipOnEmpty' => true, 'pattern' => '/^1[3578][0-9]{9}$/', 'message' => '{attribute}格式错误'],
            ['c_mobile', 'unique', 'skipOnEmpty' => true, 'message' => '{attribute}已存在'],
            /**
             * 邮箱
             */
            ['c_email', 'string', 'max' => 50],
            ['c_email', 'email', 'skipOnEmpty' => true, 'message' => '{attribute}格式错误'],
            ['c_email', 'unique', 'skipOnEmpty' => true, 'message' => '{attribute}已存在'],
            /**
             * 其他
             */
            [['c_status', 'c_role_id', 'c_login_total', 'c_last_login_time', 'c_last_ip', 'c_create_time'], 'integer'],
            [['c_update_time', 'c_access_token', 'c_auth_key', 'c_login_random'], 'safe'],
            /**
             * 密码
             */
            [['old_password', 'new_password', 'confirm_password'], 'string', 'length' => [6, 20], 'tooLong' => '{attribute}长度最多为{max}个字符', 'tooShort' => '{attribute}长度最少为{min}个字符'],
            [['new_password', 'confirm_password'], 'required', 'message' => '{attribute}不能为空', 'on' => ['create', 'my-password', 'update-password']],
            [['old_password'], 'required', 'message' => '{attribute}不能为空', 'on' => ['my-password']],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => '两次密码不一致', 'on' => ['create', 'my-password', 'update-password']],
            ['old_password', 'validatePassword', 'on' => ['my-password']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_login_random' => '登录的随机密码',
            'c_mobile' => '手机号',
            'c_password' => '密码',
            'c_auth_key' => 'cookie用户认证',
            'c_admin_name' => '用户名',
            'c_email' => '邮箱',
            'c_status' => '状态',
            'c_role_id' => '角色',
            'c_login_total' => '登录次数',
            'c_last_login_time' => '最后登录时间',
            'c_last_ip' => '最后登录IP',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
            'old_password' => '原密码',
            'new_password' => '新密码',
            'confirm_password' => '确认新密码',
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['c_admin_name', 'new_password', 'confirm_password', 'c_login_random', 'c_auth_key', 'c_mobile', 'c_email', 'c_role_id', 'c_status', 'c_create_time'];
        $scenarios['update'] = ['c_mobile', 'c_email', 'c_role_id', 'c_status'];
        $scenarios['update-password'] = ['new_password', 'confirm_password'];
        $scenarios['my-password'] = ['old_password', 'new_password', 'confirm_password'];
        $scenarios['my-info'] = ['c_mobile', 'c_email'];
        return $scenarios;
    }

    public function validatePassword($attribute) {
        if (!$this->hasErrors()) {
            if ($this->c_password != self::generatePassword($this->old_password, $this->c_login_random)) {
                $this->addError($attribute, Yii::t('common', Common::PASSWORD_OLD_CHECK_FAIL));
            }
        }
    }

    public function getAdminRole() {
        return $this->hasOne(AdminRole::className(), ['c_id' => 'c_role_id']);
    }

    public function getRole() {
        if (!$this->_role) {
            $data = static::getDb()->cache(function ($db) {
                $sql = 'SELECT c.c_route FROM t_admin_role AS a LEFT JOIN t_admin_role_node AS b ON a.c_id=b.c_role_id LEFT JOIN t_admin_route AS c ON b.c_route_id=c.c_id WHERE a.c_status=1 AND b.c_status=1 AND a.c_id=' . $this->c_role_id;
                return $db->createCommand($sql)->queryAll();
            });
            $array = [];
            foreach ($data as $v) {
                $array[] = $v['c_route'];
            }
            $this->_role = $array;
        }
        return $this->_role;
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
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

    public static function findByAdminName($admin_name) {
        return static::findOne(['c_admin_name' => $admin_name, 'c_status' => self::STATUS_YES]);
    }

    public static function findByMobile($mobile) {
        return static::findOne(['c_mobile' => $mobile, 'c_status' => self::STATUS_YES]);
    }

    public static function findByEmail($email) {
        return static::findOne(['c_email' => $email, 'c_status' => self::STATUS_YES]);
    }

    public static function existAdminName($admin_name) {
        return static::findOne(['c_admin_name' => $admin_name]);
    }

    public static function existMobile($mobile) {
        return static::findOne(['c_mobile' => $mobile]);
    }

    public static function existEmail($email) {
        return static::findOne(['c_email' => $email]);
    }

    /**
     * 设置密码
     * @return boolean
     */
    public function updatePassword() {
        if ($this->validate()) {
            $this->settingLoginPassword($this->new_password);
            return $this->save(false); //取消第二次验证
        }
        return false;
    }

    /**
     * 设置密码
     * @param type $password
     */
    public function settingLoginPassword($password) {
        $random_str = Yii::$app->security->generateRandomString(4);
        $this->c_login_random = $random_str;
        $this->c_password = self::generatePassword($password, $random_str);
        $this->c_auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * 密码加密算法
     * @param type $password
     * @param type $random_str
     * @return type
     */
    public static function generatePassword($password, $random_str) {
        return md5(md5($password) . $random_str);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->scenario == 'create') {
                $this->settingLoginPassword($this->new_password);
            }
            return true;
        }
        return false;
    }

}
