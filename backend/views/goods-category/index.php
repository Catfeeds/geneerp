<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Upload;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '商品类别列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['GoodsCategorySearch']['pagesize']) ? $get['GoodsCategorySearch']['pagesize'] : '';
$keyword = isset($get['GoodsCategorySearch']['keyword']) ? trim($get['GoodsCategorySearch']['keyword']) : '';
$status = isset($get['GoodsCategorySearch']['status']) ? $get['GoodsCategorySearch']['status'] : '';
$parent_id = (int) Yii::$app->request->get('parent_id', 0);
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Util::getStatusText(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <div class="pull-right">
            <?php if ($parent_id) { ?>
                <button class="btn btn-default" onclick="window.history.go(-1);"><i class="glyphicon glyphicon-triangle-left"></i> 返回上级</button>
            <?php } ?>
            <?php if (CheckRule::checkRole('goods-category/create')) { ?>
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', Url::to(['create', 'parent_id' => $parent_id]), ['class' => 'btn btn-success']) ?>
            <?php } ?>
        </div>
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
                    'attribute' => 'c_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_status);
                    },
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{list}</span><span class="pr20">{update}</span><span class="pr20">{delete}</span>',
                    'buttons' => [
                        'list' => function ($url, $model, $key) {
                            $options = ['title' => '查看子类', 'aria-label' => '查看子类', 'data-pjax' => '0'];
                            return Html::a('<i class="glyphicon glyphicon-th-list"></i>', Url::to(['index', 'parent_id' => $key]), $options);
                        },
                            ],
                            'visibleButtons' => [
                                'update' => CheckRule::checkRole('goods-category/update'),
                                'delete' => CheckRule::checkRole('goods-category/delete')
                            ]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
    </div>
</div>