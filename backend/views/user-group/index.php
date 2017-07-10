<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\CheckRule;
use backend\widgets\GridView;

$this->title = '用户组列表';
?>
<div class="box box-primary">
    <div class="box-header">
        <?php if (CheckRule::checkRole('user-group/create')) { ?>
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
                'c_discount',
                'c_minexp',
                'c_maxexp',
                'c_icon',
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{delete}</span><span class="pr20">{update}</span>',
                    'visibleButtons' => [
                        'delete' => CheckRule::checkRole('user-group/delete'),
                        'update' => CheckRule::checkRole('user-group/update')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>