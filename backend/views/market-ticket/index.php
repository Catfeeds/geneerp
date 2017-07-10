<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use backend\widgets\SearchForm;
use backend\widgets\GridView;

$this->title = '代金券列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['MarketTicketSearch']['pagesize']) ? $get['MarketTicketSearch']['pagesize'] : '';
$keyword = isset($get['MarketTicketSearch']['keyword']) ? trim($get['MarketTicketSearch']['keyword']) : '';
$status = isset($get['MarketTicketSearch']['status']) ? $get['MarketTicketSearch']['status'] : '';
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
        <?php if (CheckRule::checkRole('market-ticket/create')) { ?>
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
                [
                    'attribute' => 'c_title',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_title) : $model->c_title;
                    }
                ],
                'c_value', 'c_count', 'c_point', 'c_exp',
                [
                    'attribute' => 'c_start_time',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'c_end_time',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
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
                    'template' => '<span class="pr20">{add}</span><span class="pr20">{export}</span><span class="pr20">{update}</span><span class="pr20">{delete}</span><span class="pr20">{show}</span>',
                    'buttons' => [
                        'add' => function ($url, $model, $key) {
                            if ($model->c_status == 1) {
                                return Html::button('<i class="glyphicon glyphicon-credit-card"></i> 新增卡号', ['class' => 'btn btn-primary btn-add', 'data-url' => Url::to(['add', 'id' => $key])]);
                            }
                        },
                                'export' => function ($url, $model, $key) {
                            if ($model->c_count > 0) {
                                $options = ['title' => '导出卡号', 'aria-label' => '导出卡号', 'data-pjax' => '0'];
                                return Html::a('<i class="glyphicon glyphicon-download"></i>', Url::to(['export', 'id' => $key]), $options);
                            }
                        },
                                'show' => function ($url, $model, $key) {
                            if ($model->c_count > 0) {
                                $options = ['title' => '查看卡号', 'aria-label' => '查看卡号', 'data-pjax' => '0'];
                                return Html::a('<i class="glyphicon glyphicon-th-list"></i>', Url::to(['market-card/index', 'ticket_id' => $key]), $options);
                            }
                        },
                                'delete' => function ($url, $model, $key) {
                            if ($model->c_status == 2) {
                                $options = ['title' => '删除代金券', 'aria-label' => '删除代金券', 'data-pjax' => '0', 'data-method' => 'post'];
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, $options);
                            }
                        },
                            ],
                            'visibleButtons' => [
                                'update' => CheckRule::checkRole('market-ticket/update'),
                                'delete' => CheckRule::checkRole('market-ticket/delete'),
                                'add' => CheckRule::checkRole('market-ticket/add'),
                                'export' => CheckRule::checkRole('market-ticket/export'),
                                'show' => CheckRule::checkRole('market-card/index'),
                            ]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
        <?php
        $js = <<<EOT
            $(function () {
                $('.btn-add').click(function () {
                    bootboxPromptCard($(this).attr('data-url'));
                });
            });
EOT;
        backend\assets\AppAsset::addScript($js);
        