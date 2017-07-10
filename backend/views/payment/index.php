<?php

use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Upload;
use common\models\Payment;
use backend\widgets\GridView;

$this->title = '支付方式列表';
?>
<div class="box box-primary">
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
                    'attribute' => 'c_logo',
                    'format' => ['image', ['height' => 50]],
                    'value' => function ($model) {
                        return Upload::getUploadUrl() . 'payment/' . $model->c_logo;
                    }
                ],
                [
                    'attribute' => 'c_url',
                    'format' => 'url',
                    'value' => function($model) {
                        return $model->c_url;
                    }
                ],
                [
                    'attribute' => 'c_description',
                    'headerOptions' => ['width' => 200]
                ],
                [
                    'attribute' => 'c_poundage_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Payment::getClientType($model->c_poundage_type);
                    },
                ],
                [
                    'attribute' => 'c_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_status);
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{update}</span>',
                    'visibleButtons' => [
                        'update' => CheckRule::checkRole('payment/update')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>