<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\CheckRule;
use backend\widgets\GridView;

$this->title = '商品模型列表';
?>
<div class="box box-primary">
    <div class="box-header">
        <?php if (CheckRule::checkRole('goods-model/create')) { ?>
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
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{update}</span><span class="pr20">{delete}</span>',
                    'visibleButtons' => [
                        'update' => CheckRule::checkRole('goods-model/update'),
                        'delete' => CheckRule::checkRole('goods-model/delete')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>