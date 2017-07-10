<?php

namespace common\models;

use Yii;
use common\extensions\String;
use common\extensions\Util;

/**
 * This is the model class for table "{{%market_ticket}}".
 *
 * @property string $c_id
 * @property string $c_admin_name
 * @property string $c_title
 * @property string $c_goods_ids
 * @property string $c_note
 * @property string $c_value
 * @property integer $c_status
 * @property integer $c_number_type
 * @property integer $c_password_type
 * @property integer $c_number_length
 * @property integer $c_password_length
 * @property string $c_count
 * @property string $c_exp
 * @property string $c_point
 * @property string $c_start_time
 * @property string $c_end_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class MarketTicket extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%market_ticket}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_value', 'c_count', 'c_exp', 'c_point', 'c_start_time', 'c_end_time'], 'filter', 'filter' => 'trim'],
            [['c_title', 'c_value', 'c_exp', 'c_point', 'c_number_type', 'c_password_type', 'c_number_length', 'c_password_length', 'c_start_time', 'c_end_time'], 'required'],
            ['c_count', 'default', 'value' => 0],
            [['c_value'], 'number'],
            [['c_status', 'c_number_type', 'c_password_type', 'c_number_length', 'c_password_length', 'c_count', 'c_exp', 'c_point', 'c_create_time'], 'integer'],
            [['c_update_time', 'c_start_time', 'c_end_time'], 'safe'],
            [['c_admin_name'], 'string', 'max' => 20],
            [['c_title'], 'string', 'max' => 50],
            [['c_goods_ids', 'c_note'], 'string', 'max' => 255],
            [['c_title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_admin_name' => '管理员用户名',
            'c_title' => '代金券名称',
            'c_goods_ids' => '限定商品ID',
            'c_note' => '备注',
            'c_value' => '面值',
            'c_status' => '状态',
            'c_number_type' => '卡号生成类型', //卡号生成类型不区分大小写 1数字 2字母 3数字与字母混合
            'c_password_type' => '密码生成类型', //密码生成类型不区分大小写 1数字 2字母 3数字与字母混合
            'c_number_length' => '卡号位数',
            'c_password_length' => '密码位数',
            'c_count' => '卡号数量',
            'c_exp' => '所需经验值',
            'c_point' => '所需积分',
            'c_start_time' => '生效时间',
            'c_end_time' => '到期时间',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getStatus($type = null) {
        $array = [1 => '可编辑', 2 => '不可编辑'];
        return Util::getStatusText($type, $array);
    }

    public static function getType($type = null) {
        $array = [1 => '数字', 2 => '字母', 3 => '数字与字母混合'];
        return Util::getStatusText($type, $array);
    }

    public static function add($id, $count) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = MarketTicket::findOne($id);
            $n = 0;
            for ($i = 0; $i < $count; $i++) {
                $number = String::randString($model->c_number_length, $model->c_number_type);
                $data = [];
                $data['c_ticket_id'] = $id;
                $data['c_title'] = $model->c_title;
                $data['c_number'] = $number;
                $data['c_password'] = String::randString($model->c_password_length, $model->c_password_type);
                $data['c_value'] = $model->c_value;
                $data['c_start_time'] = $model->c_start_time;
                $data['c_end_time'] = $model->c_end_time;
                $result_add = MarketCard::add($number, $data);
                if ($result_add) {
                    $n++;
                }
            }
            $model->c_count += $n;
            $result = $model->save();
            if ($result) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return self::checkModel($model);
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            self::systemLog($e);
            return $e->getMessage();
        }
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->c_admin_name = Yii::$app->user->identity->c_admin_name;
            }
            $this->c_start_time = strtotime($this->c_start_time);
            $this->c_end_time = strtotime($this->c_end_time);
            return true;
        }
        return false;
    }

}
