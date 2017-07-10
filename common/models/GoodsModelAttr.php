<?php

namespace common\models;

/**
 * This is the model class for table "{{%goods_model_attr}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_value
 * @property integer $c_type
 * @property integer $c_search
 * @property string $c_model_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsModelAttr extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_model_attr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_value'], 'string'],
            [['c_type', 'c_search', 'c_model_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_title' => '属性名称',
            'c_value' => '属性值',
            'c_type' => '类型', // 1单选 2复选 3下拉 4输入框
            'c_search' => '是否支持搜索', // 1支持2不支持
            'c_model_id' => '商品模型ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getAttrType() {
        return [1 => '单选框', 2 => '复选框', 3 => '下拉框', 4 => '输入框'];
    }

    /**
     * 按模型ID为key 格式化数据
     * @param array $default_attr 默认值
     * @param array $where
     * @return array
     */
    public static function getModelAttr($default_attr = [], $where = null) {
        $result = static::findId($where);
        $data = [];
        foreach ($result as $v) {
            $default = $v->c_type == 2 ? [] : '';
            if (isset($default_attr[$v->c_id])) {
                $default = $v->c_type == 2 ? explode(',', $default_attr[$v->c_id]) : $default_attr[$v->c_id];
            }
            $data[$v->c_model_id][] = ['id' => $v->c_id, 'title' => $v->c_title, 'value' => explode(',', $v->c_value), 'type' => (string) $v->c_type, 'default' => $default];
        }
        return $data;
    }

    public static function addMore($model_id, $array) {
        if ($array) {
            $value_array = $array['value'];
            $type_array = $array['type'];
            $title_array = $array['title'];
            $search_array = array_values($array['search']); //重新格式化此参数
            GoodsModelAttr::deleteAll(['c_model_id' => $model_id]);
            $model = new GoodsModelAttr();
            foreach ($title_array as $k => $title) {
                if ($title && $value_array[$k]) {
                    $obj = clone $model;
                    $obj->c_title = $title;
                    $obj->c_value = $value_array[$k];
                    $obj->c_type = $type_array[$k];
                    $obj->c_search = $search_array[$k];
                    $obj->c_model_id = $model_id;
                    $obj->c_create_time = time();
                    $obj->save();
                }
            }
        }
    }

}
