<?php

namespace common\models;

use Yii;
use common\extensions\Util;

/**
 * This is the model class for table "{{%delivery}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_description
 * @property string $c_area_id_array
 * @property string $c_first_price_array
 * @property string $c_second_price_array
 * @property string $c_first_price
 * @property string $c_second_price
 * @property string $c_insured_rate
 * @property string $c_low_price
 * @property integer $c_type
 * @property integer $c_status
 * @property integer $c_is_insured
 * @property integer $c_price_type
 * @property integer $c_open_default
 * @property string $c_first_weight
 * @property string $c_second_weight
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Delivery extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%delivery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_description', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title', 'c_first_price', 'c_second_price', 'c_type', 'c_status', 'c_sort'], 'required'],
            [['c_area_id_array', 'c_first_price_array', 'c_second_price_array'], 'string'],
            [['c_first_price', 'c_second_price', 'c_insured_rate', 'c_low_price'], 'number'],
            [['c_type', 'c_status', 'c_is_insured', 'c_price_type', 'c_open_default', 'c_first_weight', 'c_second_weight', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
            [['c_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '配送名称',
            'c_description' => '配送描述',
            'c_area_id_array' => '配送区域ID',
            'c_first_price_array' => '配送地区对应的首重费用',
            'c_second_price_array' => '配送地区对应的续重费用',
            'c_first_price' => '首重费用(元)',
            'c_second_price' => '续重费用(元)',
            'c_insured_rate' => '保价费率',
            'c_low_price' => '最低保价',
            'c_type' => '配送类型', // 1先付款后发货 2先发货后付款 3自提点
            'c_status' => '状态',
            'c_is_insured' => '是否支持物流保价', // 1支持保价 2不支持保价
            'c_price_type' => '运费类型', // 1统一区域运费 2指定区域运费
            'c_open_default' => '其他地区启用默认费用', // 1启用 2不启用
            'c_first_weight' => '首重重量(克)',
            'c_second_weight' => '续重重量(克)',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getType($type = null) {
        $array = [1 => '先付款后发货', 2 => '先发货后付款 ', 3 => '自提点'];
        return Util::getStatusText($type, $array);
    }

    public static function getWeight($type = null) {
        $array = [
            500 => '500克',
            1000 => '1千克',
            1200 => '1.2千克',
            1500 => '1.5千克',
            2000 => '2千克',
            5000 => '5千克',
            10000 => '10千克',
            20000 => '20千克',
            50000 => '50千克',
        ];
        return Util::getStatusText($type, $array);
    }

    public static function getInsured($type = null) {
        $array = [2 => '不支持保价', 1 => '支持保价'];
        return Util::getStatusText($type, $array);
    }

    public static function getPriceType($type = null) {
        $array = [1 => '统一区域运费', 2 => '指定区域运费'];
        return Util::getStatusText($type, $array);
    }

    public static function getDeliveryFormat() {
        $delivery = [];
        $data = Delivery::find()->all();
        foreach ($data as $v) {
            $delivery[$v->c_id] = [ 'type' => (string) $v->c_type, 'title' => $v->c_title];
        }
        return $delivery;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $data = Yii::$app->request->post();
            //只有指定区域运费才保存
            if ($this->c_price_type == 2 && isset($data['first_price_array'])) {
                $this->c_first_price_array = json_encode($data['first_price_array']);
                $this->c_second_price_array = json_encode($data['second_price_array']);
                $this->c_area_id_array = json_encode($data['area_id_array']);
            } else {
                $this->c_first_price_array = '';
                $this->c_second_price_array = '';
                $this->c_area_id_array = '';
            }
            return true;
        }
        return false;
    }

}
