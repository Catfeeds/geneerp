<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Feedback;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '反馈列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['FeedbackSearch']['pagesize']) ? $get['FeedbackSearch']['pagesize'] : '';
$keyword = isset($get['FeedbackSearch']['keyword']) ? trim($get['FeedbackSearch']['keyword']) : '';
$status = isset($get['FeedbackSearch']['status']) ? $get['FeedbackSearch']['status'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Feedback::getStatus(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
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
                [
                    'attribute' => 'c_title',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_title) : $model->c_title;
                    }
                ],
                [
                    'attribute' => 'c_full_name',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_full_name) : $model->c_full_name;
                    }
                ],
                [
                    'attribute' => 'c_mobile',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_mobile) : $model->c_mobile;
                    }
                ],
                [
                    'attribute' => 'c_phone',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_phone) : $model->c_phone;
                    }
                ],
                [
                    'attribute' => 'c_email',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_email) : $model->c_email;
                    }
                ],
                [
                    'attribute' => 'c_note',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_note) : $model->c_note;
                    }
                ],
                [
                    'attribute' => 'c_reply_type',
                    'value' => function($model) {
                        return Feedback::getReplyType($model->c_reply_type);
                    },
                ],
                [
                    'attribute' => 'c_status',
                    'value' => function($model) {
                        return Feedback::getStatus($model->c_status);
                    },
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{view}</span><span class="pr20">{operation}</span>',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $options = ['title' => '查看反馈', 'aria-label' => '查看反馈', 'data-pjax' => '0'];
                            return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', Url::to(['view', 'id' => $model->c_id]), $options);
                        },
                                'operation' => function ($url, $model, $key) {
                            $options = ['title' => '处理反馈', 'aria-label' => '处理反馈', 'data-pjax' => '0'];
                            return Html::a('<i class="glyphicon glyphicon-cog"></i>', Url::to(['operation', 'id' => $model->c_id]), $options);
                        }
                            ],
                            'visibleButtons' => [
                                'view' => CheckRule::checkRole('feedback/view'),
                                'operation' => CheckRule::checkRole('feedback/operation'),
                            ]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
    </div>
</div>