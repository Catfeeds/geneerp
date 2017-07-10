<?php

namespace common\models;

use Yii;
use common\extensions\Util;
use common\extensions\String;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_short
 * @property string $c_seo
 * @property string $c_keyword
 * @property string $c_search_keyword
 * @property string $c_description
 * @property string $c_ad_picture
 * @property string $c_picture
 * @property string $c_number
 * @property string $c_unit
 * @property string $c_cost_price
 * @property string $c_market_price
 * @property string $c_sell_price
 * @property integer $c_status
 * @property string $c_brand_id
 * @property string $c_model_id
 * @property string $c_weight
 * @property string $c_exp
 * @property string $c_point
 * @property string $c_favorite_count
 * @property string $c_grade_count
 * @property string $c_sale_count
 * @property string $c_comment_count
 * @property string $c_store_count
 * @property string $c_hits_count
 * @property string $c_sort
 * @property string $c_up_time
 * @property string $c_down_time
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Goods extends _CommonModel {

    const GOODS_ONLINE = 1;
    const GOODS_CHECK = 2;
    const GOODS_OFFLINE = 3;

    public $label;
    public $category;
    public $goods_attr;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_seo', 'c_keyword', 'c_search_keyword', 'c_description', 'c_sort', 'c_short'], 'filter', 'filter' => 'trim'],
            [['c_title'], 'required'],
            [['c_cost_price', 'c_market_price', 'c_sell_price'], 'number'],
            [['c_model_id', 'c_brand_id'], 'default', 'value' => 0],
            [['c_status', 'c_brand_id', 'c_model_id', 'c_weight', 'c_exp', 'c_point', 'c_favorite_count', 'c_grade_count', 'c_sale_count', 'c_comment_count', 'c_store_count', 'c_hits_count', 'c_sort', 'c_up_time', 'c_down_time', 'c_create_time'], 'integer'],
            [['c_update_time', 'label', 'category', 'goods_attr'], 'safe'],
            [['c_title', 'c_seo', 'c_keyword', 'c_search_keyword', 'c_description', 'c_ad_picture'], 'string', 'max' => 255],
            [['c_short'], 'string', 'max' => 150],
            [['c_picture'], 'string', 'max' => 1000],
            [['c_number'], 'string', 'max' => 50],
            [['c_unit'], 'string', 'max' => 10],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['label', 'category', 'goods_attr', 'c_title', 'c_short', 'c_seo', 'c_keyword', 'c_search_keyword', 'c_description', 'c_ad_picture', 'c_picture', 'c_number', 'c_unit', 'c_cost_price', 'c_market_price', 'c_sell_price', 'c_status', 'c_brand_id', 'c_model_id', 'c_weight', 'c_exp', 'c_point', 'c_store_count', 'c_sort', 'c_create_time'];
        $scenarios['update'] = ['label', 'category', 'goods_attr', 'c_title', 'c_short', 'c_seo', 'c_keyword', 'c_search_keyword', 'c_description', 'c_ad_picture', 'c_picture', 'c_number', 'c_unit', 'c_cost_price', 'c_market_price', 'c_sell_price', 'c_status', 'c_brand_id', 'c_model_id', 'c_weight', 'c_exp', 'c_point', 'c_store_count', 'c_sort'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '商品名称',
            'c_short' => '短名称',
            'c_seo' => '标题优化',
            'c_keyword' => '关键词',
            'c_search_keyword' => '商品搜索词库 逗号分隔',
            'c_description' => '描述',
            'c_ad_picture' => '宣传图片',
            'c_picture' => '商品相册',
            'c_number' => '商品货号',
            'c_unit' => '计量单位',
            'c_cost_price' => '成本价格',
            'c_market_price' => '市场价格',
            'c_sell_price' => '销售价格',
            'c_status' => '商品状态', // 1已上架 2申请上架 3已下架
            'c_brand_id' => '商品品牌',
            'c_model_id' => '商品模型',
            'c_weight' => '重量(克)',
            'c_exp' => '购买成功增加经验值',
            'c_point' => '购买成功增加积分',
            'c_favorite_count' => '收藏次数',
            'c_grade_count' => '评分总数',
            'c_sale_count' => '销售总量',
            'c_comment_count' => '评论次数',
            'c_store_count' => '库存总量',
            'c_hits_count' => '点击总数',
            'c_sort' => '排序',
            'c_up_time' => '上架时间',
            'c_down_time' => '下架时间',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
            'label' => '商品标签',
            'category' => '商品类别'
        ];
    }

    public static function getExportField() {
        return [
            'c_id' => '商品ID',
            'c_title' => '商品名称',
            'c_picture' => '商品相册',
            'c_number' => '商品货号',
            'c_unit' => '计量单位',
            'c_cost_price' => '成本价格',
            'c_market_price' => '市场价格',
            'c_sell_price' => '销售价格',
            'c_status' => '商品状态',
            'c_brand_id' => '品牌',
            'c_weight' => '重量',
            'c_exp' => '经验值',
            'c_point' => '积分',
            'c_favorite_count' => '收藏次数',
            'c_grade_count' => '评分总数',
            'c_sale_count' => '销售总量',
            'c_comment_count' => '评论次数',
            'c_store_count' => '库存总量',
            'c_hits_count' => '点击总数',
            'c_up_time' => '上架时间',
            'c_down_time' => '下架时间',
            'c_create_time' => '创建时间',
            'goodsCategories' => '商品分类'
        ];
    }

    public function getGoodsBrand() {
        return $this->hasOne(GoodsBrand::className(), ['c_id' => 'c_brand_id']);
    }

    public function getGoodsText() {
        return $this->hasOne(GoodsText::className(), ['c_goods_id' => 'c_id']);
    }

    public function getGoodsCategoryExtend() {
        return $this->hasMany(GoodsCategoryExtend::className(), ['c_goods_id' => 'c_id']);
    }

    public function getGoodsLabel() {
        return $this->hasMany(GoodsLabel::className(), ['c_goods_id' => 'c_id']);
    }

    public function getGoodsAttr() {
        return $this->hasMany(GoodsAttr::className(), ['c_goods_id' => 'c_id']);
    }

    public static function getLabel() {
        return [1 => '最新商品', 2 => '特价商品', 3 => '热卖排行', 4 => '推荐商品'];
    }

    public static function getStatus($type = null) {
        $array = [self::GOODS_ONLINE => '已上架', self::GOODS_CHECK => '申请上架', self::GOODS_OFFLINE => '已下架'];
        return Util::getStatusText($type, $array);
    }

    //创建商品货号
    public static function createGoodsNumber() {
        $prefix = isset(Yii::$app->params['number_prefix']) && Yii::$app->params['number_prefix'] ? Yii::$app->params['number_prefix'] : 'JJ';
        return $prefix . time() . rand(10, 99);
    }

    public static function getLabelTitle($types) {
        $result = [];
        if ($types) {
            $label = self::getLabel();
            foreach ($types as $type) {
                if (isset($label[$type])) {
                    $result[] = $label[$type];
                }
            }
        }
        return $result;
    }

    public static function getLabelHtml($types) {
        $html = '';
        $data = self::getLabelTitle($types);
        if ($data) {
            foreach ($data as $v) {
                $html .= '<span class="label label-primary">' . $v . '</span> ';
            }
        }
        return $html;
    }

    public static function getGoodsByCategory() {
        $result = Goods::find()->with(['goodsCategoryExtend'])->all();
        $data = [];
        foreach ($result as $model) {
            if (isset($model->goodsCategoryExtend)) {
                foreach ($model->goodsCategoryExtend as $category) {
                    $data[$category->c_category_id][$model->c_id] = ['c_goods_id' => $model->c_id, 'c_title' => $model->c_title, 'c_picture' => Upload::getThumbOne($model->c_picture), 'c_sell_price' => $model->c_sell_price, 'c_count' => 1];
                }
            }
        }
        return $data;
    }

//    //新增库存
//    public static function addStoreCount($goods_id, $count) {
//        $model_goods = Goods::findOne($goods_id);
//        $model_goods->c_store_count += $count;
//        return $model_goods->save();
//    }
//
//    //减少库存
//    public static function subtractStoreCount($goods_id, $count) {
//        $model_goods = Goods::findOne($goods_id);
//        $model_goods->c_store_count -= $count;
//        return $model_goods->save();
//    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (in_array($this->scenario, ['create', 'update'])) {
                //图片处理
                $this->c_picture = Yii::$app->request->post('picture_list', '');
                $this->c_ad_picture = Yii::$app->request->post('ad_picture', '');
                if ($insert) {
                    //自动设置描述
                    $editor = Yii::$app->request->post('pc_content');
                    if (empty($this->c_description) && $editor) {
                        $this->c_description = String::msubstr(Util::filterStringRelace($editor), 0, 80);
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 保存之后处理相关数据
     * @param type $insert
     * @param type $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if (in_array($this->scenario, ['create', 'update'])) {
            //图片或附件处理
            Upload::updateFile($insert, $this->c_id);
            Upload::updateFile($insert, $this->c_id, Upload::UPLOAD_PICTURE, 'ad_picture');
            //更新编辑器上传图片为已上传
            foreach (Yii::$app->params['editor_dir'] as $v) {
                Upload::updateByPath($this->c_id, Yii::$app->request->post('content_' . $v));
            }
            GoodsText::addEdit($this->c_id, Yii::$app->request->post('pc_content'), Yii::$app->request->post('h5_content'), Yii::$app->request->post('app_content'));
            GoodsLabel::addMore($this->c_id, $this->label);
            GoodsAttr::addMore($this->c_id, $this->c_model_id, $this->goods_attr);
            GoodsCategoryExtend::addMore($this->c_id, $this->category);
            if ($insert) {
                GoodsHits::add($this->c_id);
            }
        }
    }

}
