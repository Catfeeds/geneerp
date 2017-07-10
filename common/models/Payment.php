<?php

namespace common\models;

use common\extensions\Util;

/**
 * This is the model class for table "{{%payment}}".
 *
 * @property string $c_id
 * @property string $c_pay_id
 * @property string $c_title
 * @property string $c_logo
 * @property string $c_url
 * @property string $c_description
 * @property string $c_content
 * @property string $c_poundage
 * @property integer $c_poundage_type
 * @property integer $c_type
 * @property integer $c_status
 * @property integer $c_client_type
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Payment extends _CommonModel {

    const CLIENT_PC = 1;
    const CLIENT_MOBILE = 2;
    const CLIENT_COMMON = 3;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_logo', 'c_url', 'c_description', 'c_title', 'c_poundage', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_id', 'c_title', 'c_status', 'c_sort'], 'required'],
            [['c_id', 'c_poundage_type', 'c_type', 'c_status', 'c_client_type', 'c_sort', 'c_create_time'], 'integer'],
            [['c_content'], 'string'],
            [['c_poundage'], 'number'],
            [['c_update_time'], 'safe'],
            [['c_pay_id', 'c_title'], 'string', 'max' => 50],
            [['c_logo', 'c_url', 'c_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_pay_id' => '支付标识',
            'c_title' => '支付名称',
            'c_logo' => '支付方式logo',
            'c_url' => '官方网址',
            'c_description' => '描述',
            'c_content' => '支付说明',
            'c_poundage' => '手续费',
            'c_poundage_type' => '手续费方式', //1按商品总额的百分比 2按固定金额
            'c_type' => '类型 1线上 2线下',
            'c_status' => '安装状态',
            'c_client_type' => '客户端类型', // 1PC端 2移动端 3通用
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getPoundageType($type = null) {
        $array = [1 => '按商品总额的百分比', 2 => '按固定金额'];
        return Util::getStatusText($type, $array);
    }

    public static function getClientType($type = null) {
        $array = [self::CLIENT_PC => 'PC端', self::CLIENT_MOBILE => '移动端', self::CLIENT_COMMON => '通用'];
        return Util::getStatusText($type, $array);
    }

    /**
     * 获取后台管理员支付方式
     * @param type $type
     * @return type
     */
    public static function getPaymentByAdmin($type) {
        $where = ['>', 'c_id', 0];//非线下支付
        if ($type == 2) {
            $where = ['c_id' => 0]; //线下支付
        }
        return static::getKeyValueSortCache($where);
    }

    /**
     * 获取前台用户支付方式
     * @param type $client_type 1PC端 2移动端 3公共
     * @param type $online 是否充值选择页面使用
     * @return type
     */
    public static function getPaymentByClientType($client_type = self::CLIENT_PC, $online = false) {
        $client = [$client_type, self::CLIENT_COMMON];
        $where = ['>', 'c_id', 0];
        if ($online) {
            $where = ['>', 'c_id', 1]; //过滤预存款
        }
        return static::find()->where(['c_status' => self::STATUS_YES, 'c_client_type' => $client])->andWhere($where)->orderBy(['c_sort' => SORT_DESC])->all();
    }

}
