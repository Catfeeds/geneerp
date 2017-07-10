<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use backend\widgets\GridView;

$this->title = '物流公司列表';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            快递鸟物流查询快递接口 <?= Html::a('下载物流公司代码', 'http://www.kdniao.com/file/ExpressCode.xls') ?>
        </div>
        <?php if (CheckRule::checkRole('freight-company/create')) { ?>
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
                'c_type',
                [
                    'attribute' => 'c_url',
                    'format' => 'url',
                    'value' => function($model) {
                        return $model->c_url;
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
                    'template' => '<span class="pr20">{update}</span>',
                    'visibleButtons' => [
                        'update' => CheckRule::checkRole('freight-company/update')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>