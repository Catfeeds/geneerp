<?php

namespace common\models;

/**
 * This is the model class for table "{{%goods_brand_category}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_sort
 * @property string $c_goods_category_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class GoodsBrandCategory extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods_brand_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title'], 'required'],
            [['c_sort', 'c_goods_category_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '品牌类别名称',
            'c_sort' => '排序',
            'c_goods_category_id' => '商品类别',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getGoodsCategory() {
        return $this->hasOne(GoodsCategory::className(), ['c_id' => 'c_goods_category_id']);
    }

    public static function getLabelTitle($ids) {
        $result = [];
        $data = static::findSortCache(['c_id' => $ids]);
        foreach ($data as $v) {
            $result[] = $v->c_title;
        }
        return $result;
    }

    public static function getLabelHtml($ids) {
        $html = '';
        $array = explode(',', $ids);
        $data = self::getLabelTitle($array);
        foreach ($data as $v) {
            $html .= '<span class="label label-primary">' . $v . '</span> ';
        }
        return $html;
    }

}
