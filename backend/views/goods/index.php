<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Goods;
use common\models\GoodsBrand;
use common\models\GoodsCategory;
use common\models\Upload;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '商品列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['GoodsSearch']['pagesize']) ? $get['GoodsSearch']['pagesize'] : '';
$keyword = isset($get['GoodsSearch']['keyword']) ? trim($get['GoodsSearch']['keyword']) : '';
$status = isset($get['GoodsSearch']['status']) ? $get['GoodsSearch']['status'] : '';
$category_id = isset($get['GoodsSearch']['category_id']) ? $get['GoodsSearch']['category_id'] : '';
$brand_id = isset($get['GoodsSearch']['brand_id']) ? $get['GoodsSearch']['brand_id'] : '';
$label_id = isset($get['GoodsSearch']['label_id']) ? $get['GoodsSearch']['label_id'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Goods::getStatus(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'category_id')->dropDownList(GoodsCategory::formatDropDownListCache(), ['prompt' => '选择类别', 'value' => $category_id]) ?>
            <?= $form->field($searchModel, 'brand_id')->dropDownList(GoodsBrand::getKeyValueCache(), ['prompt' => '选择品牌', 'value' => $brand_id]) ?>
            <?= $form->field($searchModel, 'label_id')->dropDownList(Goods::getLabel(), ['prompt' => '选择标签', 'value' => $label_id]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('goods/create')) { ?>
            <div class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', Url::to(['create']), ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="box-body">
        <?php Pjax::begin(); ?> 
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'c_id',
                    'headerOptions' => ['style' => 'min-width:50px']
                ],
                'c_sort',
                [
                    'attribute' => 'c_title',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_title) : $model->c_title;
                    }
                ],
                [
                    'attribute' => 'c_picture',
                    'format' => ['image', ['height' => 50]],
                    'value' => function ($model) {
                return Upload::getThumbOne($model->c_picture, true);
            }
                ],
                [
                    'attribute' => 'c_number',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_number) : $model->c_number;
                    }
                ],
                [
                    'attribute' => 'category',
                    'format' => 'raw',
                    'value' => function($model) {
                        $category_id_array = [];
                        if (isset($model->goodsCategoryExtend)) {
                            foreach ($model->goodsCategoryExtend as $category) {
                                $category_id_array[] = $category->c_category_id;
                            }
                        }
                        return GoodsCategory::getLabelHtml($category_id_array);
                    },
                        ],
                        [
                            'attribute' => 'c_brand_id',
                            'format' => 'raw',
                            'value' => function($model) {
                                return isset($model->goodsBrand->c_title) ? $model->goodsBrand->c_title : '--';
                            },
                        ],
                        [
                            'attribute' => 'label',
                            'format' => 'raw',
                            'value' => function($model) {
                                $label_array = [];
                                if (isset($model->goodsLabel)) {
                                    foreach ($model->goodsLabel as $label) {
                                        $label_array[] = $label->c_type;
                                    }
                                }
                                return Goods::getLabelHtml($label_array);
                            },
                                ],
                                [
                                    'attribute' => 'c_status',
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        return Goods::getStatus($model->c_status);
                                    },
                                ],
                                [
                                    'attribute' => 'c_create_time',
                                    'format' => ['date', 'php:Y-m-d H:i:s']
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => '管理操作',
                                    'template' => '<span class="pr20">{update}</span>',
                                    'visibleButtons' => [
                                        'update' => CheckRule::checkRole('goods/update'),
                                    ]
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
    </div>
</div>