<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property string $c_user_id
 * @property string $c_qq
 * @property string $c_full_name
 * @property string $c_head
 * @property string $c_nick_name
 * @property string $c_phone
 * @property string $c_address
 * @property string $c_sign
 * @property integer $c_sex
 * @property string $c_province_id
 * @property string $c_city_id
 * @property string $c_area_id
 * @property integer $c_birthday
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserProfile extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_user_id'], 'required'],
            [['c_user_id', 'c_sex', 'c_province_id', 'c_city_id', 'c_area_id', 'c_birthday', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_qq'], 'string', 'max' => 15],
            [['c_full_name'], 'string', 'max' => 20],
            [['c_head', 'c_nick_name', 'c_phone'], 'string', 'max' => 50],
            [['c_address','c_sign'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_user_id' => '用户ID',
            'c_qq' => 'QQ',
            'c_full_name' => '姓名',
            'c_head' => '头像',
            'c_nick_name' => '昵称',
            'c_phone' => '电话',
            'c_address' => '详细地址',
            'c_sign' => '签名',
            'c_sex' => '性别 1男 2女 3保密',
            'c_province_id' => '省份ID',
            'c_city_id' => '市级ID',
            'c_area_id' => '地区ID',
            'c_birthday' => '生日',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getSex($type = null) {
        $array = [1 => '男', 2 => '女', 3 => '保密'];
        return Util::getStatusText($type, $array);
    }

    public static function getHead($id = 0) {
        $user_id = $id ? $id : Yii::$app->user->getId();
        if ($user_id) {
            $picture = md5(md5($user_id)) . '.jpg';
            $path = Upload::getUploadPath() . 'user_head' . DIRECTORY_SEPARATOR . $picture;
            if (is_file($path)) {
                return Upload::getUploadUrl() . 'user_head/' . $picture;
            }
        }
        return self::getHeadNoPic();
    }

    //头像无图片
    public static function getHeadNoPic() {
        return Upload::getUploadUrl() . 'default/default_user_head.png';
    }

    public static function addUserProfile($user_id) {
        $model = new UserProfile();
        $model->c_user_id = $user_id;
        $model->c_create_time = time();
        return $model->save();
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ((int) Yii::$app->request->post('select_year') && (int) Yii::$app->request->post('select_month') && (int) Yii::$app->request->post('select_day')) {
                $this->c_birthday = strtotime((int) Yii::$app->request->post('select_year') . '-' . (int) Yii::$app->request->post('select_month') . '-' . (int) Yii::$app->request->post('select_day'));
            }
            return true;
        }
        return false;
    }

}
