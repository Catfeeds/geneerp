<?php

namespace common\models;

use common\extensions\Util;

/**
 * This is the model class for table "{{%market_card}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_number
 * @property string $c_password
 * @property string $c_value
 * @property integer $c_status
 * @property integer $c_is_send
 * @property integer $c_is_used
 * @property string $c_ticket_id
 * @property string $c_start_time
 * @property string $c_end_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class MarketCard extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%market_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_title', 'c_number', 'c_password'], 'required'],
            [['c_value'], 'number'],
            [['c_status', 'c_is_send', 'c_is_used', 'c_ticket_id', 'c_start_time', 'c_end_time', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title', 'c_number'], 'string', 'max' => 50],
            [['c_password'], 'string', 'max' => 64],
            [['c_number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '代金券名称',
            'c_number' => '卡号',
            'c_password' => '密码',
            'c_value' => '面值',
            'c_status' => '激活状态',
            'c_is_send' => '发放状态',
            'c_is_used' => '使用状态',
            'c_ticket_id' => '代金券类型',
            'c_start_time' => '生效时间',
            'c_end_time' => '到期时间',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getExportField() {
        return [
            'c_title' => '代金券名称',
            'c_number' => '卡号',
            'c_password' => '密码',
            'c_value' => '面值',
            'c_status' => '激活状态',
            'c_is_send' => '发放状态',
            'c_is_used' => '使用状态',
            'c_start_time' => '生效时间',
            'c_end_time' => '到期时间',
            'c_create_time' => '创建时间',
        ];
    }

    public static function getUsedStatus($type = null) {
        $array = [1 => '已使用', 2 => '未使用'];
        return Util::getStatusText($type, $array);
    }

    public static function getSendStatus($type = null) {
        $array = [1 => '已发放', 2 => '未发放'];
        return Util::getStatusText($type, $array);
    }

    public static function add($number, $data) {
        $result = MarketCard::findOne(['c_number' => $number]);
        if ($result) {
            return false;
        } else {
            $model = new MarketCard();
            $model->attributes = $data;
            $model->c_create_time = time();
            return $model->save();
        }
    }

    public static function validateCard($number, $password) {
        return MarketCard::findOne(['c_number' => $number, 'c_password' => $password]);
    }

    public function afterDelete() {
        parent::afterDelete();
        $count = MarketCard::find()->where(['c_ticket_id' => $this->c_ticket_id])->count();
        MarketTicket::updateAll(['c_count' => $count], ['c_id' => $this->c_ticket_id]);
    }

}
