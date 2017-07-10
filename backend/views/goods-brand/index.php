<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\CheckRule;
use common\models\GoodsBrandCategory;
use common\models\Upload;
use backend\widgets\GridView;

$this->title = '品牌列表';
?>
<div class="box box-primary">
    <div class="box-header">
        <?php if (CheckRule::checkRole('goods-brand/create')) { ?>
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
                'c_title',
                [
                    'attribute' => 'c_picture',
                    'format' => ['image', ['height' => 50]],
                    'value' => function ($model) {
                return Upload::getThumbOne($model->c_picture, true);
            }
                ],
                [
                    'attribute' => 'c_url',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->c_url;
                    }
                ],
                [
                    'attribute' => 'c_category_ids',
                    'format' => 'raw',
                    'value' => function($model) {
                        return GoodsBrandCategory::getLabelHtml($model->c_category_ids);
                    }
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{update}</span><span class="pr20">{delete}</span>',
                    'visibleButtons' => [
                        'update' => CheckRule::checkRole('goods-brand-category/update'),
                        'delete' => CheckRule::checkRole('goods-brand-category/delete')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>