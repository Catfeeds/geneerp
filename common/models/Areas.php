<?php

namespace common\models;

use Yii;
use common\messages\Common;
use common\models\_CommonModel;

/**
 * This is the model class for table "{{%areas}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_postcode
 * @property integer $c_status
 * @property string $c_parent_id
 * @property string $c_sort
 */
class Areas extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%areas}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_postcode', 'c_sort'], 'filter', 'filter' => 'trim'],
            /**
             * 自动生成规则
             */
            [['c_title', 'c_status', 'c_sort'], 'required'],
            [['c_status', 'c_parent_id', 'c_sort'], 'integer'],
            [['c_title'], 'string', 'max' => 50],
            [['c_postcode'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '地区名称',
            'c_postcode' => '邮政编码',
            'c_status' => '状态',
            'c_parent_id' => '父级菜单',
            'c_sort' => '排序',
        ];
    }

    public static function getAreaTitle($id) {
        $result = static::findIdCache(['c_id' => $id], true);
        $data = [];
        foreach ($result as $v) {
            $data[$v['c_id']] = $v['c_title'];
        }
        ksort($data);
        return $data;
    }

    public static function make() {
        $result1 = static::make1();
        $result2 = static::make2();
        $result3 = static::make3();
        $result4 = static::make4(); //手机端选择
        if ($result1 === false || $result2 === false || $result3 === false || $result4 === false) {
            return Yii::t('common', Common::SYSTEM_WRITABLE_FAIL);
        }
        return true;
    }

    private static function make1() {
        $data = static::getTreeCache(['c_parent_id' => 0, 'c_status' => self::STATUS_YES]);
        $array = [];
        foreach ($data as $v) {
            $array[$v['c_id']] = ['name' => $v['c_title']];
        }
        return self::makeFile('district-level1', 'var districtData1=' . json_encode($array, JSON_UNESCAPED_UNICODE) . ';');
    }

    private static function make2() {
        $data = static::getTreeCache(['c_status' => self::STATUS_YES]);
        $array = [];
        foreach ($data as $v) {
            $array[$v['c_id']] = ['name' => $v['c_title']];
            if (isset($v['sub'])) {
                foreach ($v['sub'] as $vv) {
                    $array[$v['c_id']]['cell'][$vv['c_id']] = ['name' => $vv['c_title'], 'zip' => $vv['c_postcode']];
                }
            }
        }
        return self::makeFile('district-level2', 'var districtData2=' . json_encode($array, JSON_UNESCAPED_UNICODE) . ';');
    }

    private static function make3() {
        $data = static::getTreeCache(['c_status' => self::STATUS_YES]);
        $array = [];
        foreach ($data as $v) {
            $array[$v['c_id']] = ['name' => $v['c_title']];
            if (isset($v['sub'])) {
                foreach ($v['sub'] as $vv) {
                    $array[$v['c_id']]['cell'][$vv['c_id']] = ['name' => $vv['c_title'], 'zip' => $vv['c_postcode']];
                    if (isset($vv['sub'])) {
                        foreach ($vv['sub'] as $vvv) {
                            $array[$v['c_id']]['cell'][$vv['c_id']]['cell'][$vvv['c_id']] = ['name' => $vvv['c_title'], 'zip' => $vvv['c_postcode']];
                        }
                    }
                }
            }
        }
        return self::makeFile('district-all', 'var districtData=' . json_encode($array, JSON_UNESCAPED_UNICODE) . ';');
    }

    private static function make4() {
        $data = static::getTreeCache(['c_status' => self::STATUS_YES], 0, ['c_parent_id' => SORT_ASC]);
        $array = [];
        foreach ($data as $k => $v) {
            $array[$k]['value'] = $v['c_id'];
            $array[$k]['text'] = $v['c_title'];
            if (isset($v['sub'])) {
                foreach ($v['sub'] as $kk => $vv) {
                    $array[$k]['children'][$kk] = ['value' => $vv['c_id'], 'text' => $vv['c_title']];
                    if (isset($vv['sub'])) {
                        foreach ($vv['sub'] as $kkk => $vvv) {
                            $array[$k]['children'][$kk]['children'][$kkk] = ['value' => $vvv['c_id'], 'text' => $vvv['c_title']];
                        }
                    }
                }
            }
        }
        return self::makeFile('district-mobile', 'var districtData=' . json_encode($array, JSON_UNESCAPED_UNICODE) . ';');
    }

    private static function makeFile($name, $data) {
        $file = realpath(Yii::getAlias('@common')) . DIRECTORY_SEPARATOR . 'static' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'linkagesel' . DIRECTORY_SEPARATOR . $name . '.js';
        if (is_file($file) && !is_writable($file)) {
            return false;
        }
        return file_put_contents($file, $data);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (!$insert) {
                if ($this->c_parent_id == $this->c_id) { //不可以选择自己为自己的父级
                    $this->addError('c_parent_id', Yii::t('common', Common::COMMON_PARENT_ID));
                    return false;
                }
                if (static::checkSub($this->c_id, $this->c_parent_id)) {//不可以选择自己子类为父级菜单
                    $this->addError('c_parent_id', Yii::t('common', Common::COMMON_SUB_ID));
                    return false;
                }
            }
            return true;
        }
        return false;
    }

}
