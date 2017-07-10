<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_acount}}".
 *
 * @property string $c_user_id
 * @property string $c_amount
 * @property string $c_frozen_amount
 * @property string $c_exp
 * @property string $c_point
 * @property integer $c_status
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserAcount extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_acount}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_user_id'], 'required'],
            [['c_user_id', 'c_exp', 'c_point', 'c_status', 'c_create_time'], 'integer'],
            [['c_amount', 'c_frozen_amount'], 'number'],
            [['c_update_time'], 'safe'],
            [['c_user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_user_id' => '用户ID',
            'c_amount' => '账户预存款',
            'c_frozen_amount' => '冻结金额',
            'c_exp' => '经验值',
            'c_point' => '积分',
            'c_status' => '状态 1正常 2无效',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['c_id' => 'c_user_id']);
    }

    public static function addUserAcount($user_id) {
        $model = new UserAcount();
        $model->c_user_id = $user_id;
        $model->c_create_time = time();
        return $model->save();
    }

    /**
     * 新增 现在账户金额 冻结账户金额
     * @param type $user_id 用户ID
     * @param type $note_type 来源用途说明ID
     * @param type $user_type 创建类型 用户 平台 API
     * @param type $data ['amount_money'=>0,'frozen_money'=>0,'user_id'=>1,'note_type'=>0,'order_id'=>0,'note'=>'']
     * @return boolean|string
     */
    public static function addCash($user_id, $note_type, $user_type, $data) {
        return self::cash($user_id, $note_type, $user_type, $data, self::STATUS_YES);
    }

    /**
     * 减少现在账户金额 冻结账户金额
     * @param type $user_id 用户ID
     * @param type $note_type 来源用途说明ID
     * @param type $user_type 创建类型 用户 平台 API
     * @param type $data ['amount_money'=>0,'frozen_money'=>0,'user_id'=>1,'note_type'=>0,'order_id'=>0,'note'=>'']
     * @return boolean|string
     */
    public static function subCash($user_id, $note_type, $user_type, $data) {
        return self::cash($user_id, $note_type, $user_type, $data, self::STATUS_NO);
    }

    /**
     * 新增 积分 经验值
     * @param type $user_id 用户ID
     * @param type $note_type 来源用途说明ID
     * @param type $user_type 创建类型 用户 平台 API
     * @param type $data ['point'=>0,'exp'=>0,'note_type'=>0,'order_id'=>0,'note'=>'']
     * @return boolean|string
     */
    public static function addPoint($user_id, $note_type, $user_type, $data) {
        return self::point($user_id, $note_type, $user_type, $data, self::STATUS_YES);
    }

    /**
     * 减少 积分 经验值
     * @param type $user_id 用户ID
     * @param type $note_type 来源用途说明ID
     * @param type $user_type 创建类型 用户 平台 API
     * @param type $data ['point'=>0,'exp'=>0,'note_type'=>0,'order_id'=>0,'note'=>'']
     * @return boolean|string
     */
    public static function subPoint($user_id, $note_type, $user_type, $data) {
        return self::point($user_id, $note_type, $user_type, $data, self::STATUS_NO);
    }

    /**
     * 现金账户或冻结账户资金操作
     * @param type $user_id
     * @param type $note_type
     * @param type $user_type
     * @param type $data
     * @param type $type STATUS_YES新增 STATUS_NO减少
     * @return boolean|string
     */
    public static function cash($user_id, $note_type, $user_type, $data, $type) {
        if (isset($data['amount_money']) || isset($data['frozen_money'])) {
            $amount_money = isset($data['amount_money']) ? (int) $data['amount_money'] : 0;
            $frozen_money = isset($data['frozen_money']) ? (int) $data['frozen_money'] : 0;
            if ($amount_money < 0 || $frozen_money < 0 || ($amount_money == 0 && $frozen_money == 0)) {
                return '请输入大于0的金额数字。';
            }
            $order_id = isset($data['order_id']) ? $data['order_id'] : 0;
            $order_no = isset($data['order_no']) ? $data['order_no'] : '';
            $note = isset($data['note']) ? $data['note'] : '';
            $model = UserAcount::findOne($user_id);
            if ($model) {
                $data = [];
                $data['c_order_id'] = $order_id;
                $data['c_user_id'] = $user_id;
                $data['c_note_type'] = $note_type;
                $data['c_order_no'] = $order_no;
                $data['c_note'] = $note;
                $data['c_type'] = $type;
                if ($type == self::STATUS_NO) {
                    if ($amount_money && $model->c_amount < $amount_money) {//现金账户是否支持本次操作
                        return '现金账户金额不足，本次操作金额为：￥' . $amount_money;
                    }
                    if ($frozen_money && $model->c_frozen_amount < $frozen_money) {//冻结账户是否支持本次操作
                        return '冻结账户金额不足，本次操作金额为：￥' . $frozen_money;
                    }
                    if ($amount_money) {
                        $amount_data = $data;
                        $amount_data['c_amount_old'] = $model->c_amount;
                        $amount_data['c_amount'] = $amount_money;
                        $amount_data['c_amount_new'] = $model->c_amount - $amount_money;
                        UserAcountLog::add($amount_data, $user_type);
                    }
                    if ($frozen_money) {
                        $frozen_data = $data;
                        $frozen_data['c_frozen_amount_old'] = $model->c_frozen_amount;
                        $frozen_data['c_frozen_amount'] = $frozen_money;
                        $frozen_data['c_frozen_amount_new'] = $model->c_frozen_amount - $frozen_money;
                        UserAcountLog::add($frozen_data, $user_type);
                    }
                    $model->c_amount -= $amount_money;
                    $model->c_frozen_amount -= $frozen_money;
                } else {
                    if ($amount_money) {
                        $amount_data = $data;
                        $amount_data['c_amount_old'] = $model->c_amount;
                        $amount_data['c_amount'] = $amount_money;
                        $amount_data['c_amount_new'] = $model->c_amount + $amount_money;
                        UserAcountLog::add($amount_data, $user_type);
                    }
                    if ($frozen_money) {
                        $frozen_data = $data;
                        $frozen_data['c_frozen_amount_old'] = $model->c_frozen_amount;
                        $frozen_data['c_frozen_amount'] = $frozen_money;
                        $frozen_data['c_frozen_amount_new'] = $model->c_frozen_amount + $frozen_money;
                        UserAcountLog::add($frozen_data, $user_type);
                    }
                    $model->c_amount += $amount_money;
                    $model->c_frozen_amount += $frozen_money;
                }
                if ($model->save()) {
                    return true;
                }
                return false;
            } else {
                return '账户不存在';
            }
        } else {
            return '参数参数';
        }
    }

    /**
     * 
     * @param type $user_id
     * @param type $note_type
     * @param type $user_type
     * @param type $data
     * @param type $type STATUS_YES新增 STATUS_NO减少
     * @return boolean|string
     */
    public static function point($user_id, $note_type, $user_type, $data, $type) {
        if (isset($data['point']) || isset($data['exp'])) {
            $point = isset($data['point']) ? (int) $data['point'] : 0;
            $exp = isset($data['exp']) ? (int) $data['exp'] : 0;
            if ($point < 0 || $exp < 0 || ($point == 0 && $exp == 0)) {
                return '请输入大于0的数字。';
            }
            $order_id = isset($data['order_id']) ? $data['order_id'] : 0;
            $order_no = isset($data['order_no']) ? $data['order_no'] : '';
            $note = isset($data['note']) ? $data['note'] : '';
            $model = UserAcount::findOne($user_id);
            if ($model) {
                $data = [];
                $data['c_order_id'] = $order_id;
                $data['c_user_id'] = $user_id;
                $data['c_note_type'] = $note_type;
                $data['c_order_no'] = $order_no;
                $data['c_note'] = $note;
                $data['c_type'] = $type;
                if ($type == self::STATUS_NO) {
                    if ($point && $model->c_point < $point) {
                        return '账户积分不足，本次操作积分为：' . $point;
                    }
                    if ($exp && $model->c_exp < $exp) {
                        return '账户经验值不足，本次操作经验值为：' . $exp;
                    }
                    if ($point) {
                        $point_data = $data;
                        $point_data['c_point_old'] = $model->c_point;
                        $point_data['c_point'] = $point;
                        $point_data['c_point_new'] = $model->c_point - $point;
                        UserPointLog::add($point_data, $user_type);
                    }
                    if ($exp) {
                        $exp_data = $data;
                        $exp_data['c_exp_old'] = $model->c_exp;
                        $exp_data['c_exp'] = $exp;
                        $exp_data['c_exp_new'] = $model->c_exp - $exp;
                        UserPointLog::add($exp_data, $user_type);
                    }
                    $model->c_point -= $point;
                    $model->c_exp -= $exp;
                } else {
                    if ($point) {
                        $point_data = $data;
                        $point_data['c_point_old'] = $model->c_point;
                        $point_data['c_point'] = $point;
                        $point_data['c_point_new'] = $model->c_point + $point;
                        UserPointLog::add($point_data, $user_type);
                    }
                    if ($exp) {
                        $exp_data = $data;
                        $exp_data['c_exp_old'] = $model->c_exp;
                        $exp_data['c_exp'] = $exp;
                        $exp_data['c_exp_new'] = $model->c_exp + $exp;
                        UserPointLog::add($exp_data, $user_type);
                    }
                    $model->c_point += $point;
                    $model->c_exp += $exp;
                }
                if ($model->save()) {
                    return true;
                }
                return false;
            } else {
                return '账户不存在';
            }
        } else {
            return '参数参数';
        }
    }

}
