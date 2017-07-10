<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\MarketCard;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '卡号列表';
$this->params['breadcrumbs'][] = ['label' => '代金券列表', 'url' => ['market-ticket/index']];
$get = Yii::$app->request->get();
$pagesize = isset($get['MarketCardSearch']['pagesize']) ? $get['MarketCardSearch']['pagesize'] : '';
$keyword = isset($get['MarketCardSearch']['keyword']) ? trim($get['MarketCardSearch']['keyword']) : '';
$status = isset($get['MarketCardSearch']['status']) ? $get['MarketCardSearch']['status'] : '';
$is_used = isset($get['MarketCardSearch']['is_used']) ? $get['MarketCardSearch']['is_used'] : '';
$is_send = isset($get['MarketCardSearch']['is_send']) ? $get['MarketCardSearch']['is_send'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Util::getStatusText(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'is_used')->dropDownList(MarketCard::getUsedStatus(), ['prompt' => '选择使用状态', 'value' => $is_used]) ?>
            <?= $form->field($searchModel, 'is_send')->dropDownList(MarketCard::getSendStatus(), ['prompt' => '选择发放状态', 'value' => $is_send]) ?>
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
            'showFooter' => true, //设置显示最下面的footer
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'name' => 'id', //设置每行数据的复选框属性
                    //'headerOptions' => ['style' => 'min-width:50px'],
                    'footer' => '<label><input type="checkbox" class="select-on-check-all" name="id_all" value="1"> 全选</label> <button class="jquery-confirm btn btn-default" data-params="all=1" data-title="您确定要设置卡号状态未激活吗？" data-url="' . Url::to(['market-card/delete-all']) . '"><i class="glyphicon glyphicon-trash"></i> 取消激活</button> <button class="jquery-confirm btn btn-default" data-title="您确定要设置卡号状态已发放吗？" data-url="' . Url::to(['market-card/send-all']) . '"><i class="glyphicon glyphicon-bullhorn"></i> 设置发放</button> <button class="jquery-confirm btn btn-default" data-title="您确定要设置卡号状态已使用吗？" data-url="' . Url::to(['market-card/used-all']) . '"><i class="glyphicon glyphicon-ban-circle"></i> 设置使用</button>',
                    'footerOptions' => ['colspan' => 13], //设置删除按钮垮列显示；
                ],
                [
                    'attribute' => 'c_id',
                    'headerOptions' => ['style' => 'min-width:50px'],
                    'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_title',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_title) : $model->c_title;
                    }, 'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_number',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_number) : $model->c_number;
                    }, 'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_password',
                    'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_value',
                    'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_is_used',
                    'format' => 'raw',
                    'value' => function($model) {
                        return MarketCard::getUsedStatus($model->c_is_used);
                    }, 'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_is_send',
                    'format' => 'raw',
                    'value' => function($model) {
                        return MarketCard::getSendStatus($model->c_is_send);
                    }, 'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_status);
                    }, 'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_start_time',
                    'format' => ['date', 'php:Y-m-d'],
                    'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_end_time',
                    'format' => ['date', 'php:Y-m-d'],
                    'footerOptions' => ['class' => 'hide']
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                    'footerOptions' => ['class' => 'hide']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{delete}</span><span class="pr20">{send}</span><span class="pr20">{used}</span>',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            if ($model->c_status == MarketCard::STATUS_YES && $model->c_is_used == MarketCard::STATUS_NO) {
                                $options = ['title' => '取消激活', 'aria-label' => '取消激活', 'data-pjax' => '1', 'data-confirm' => '您确定要设置卡号状态未激活吗？', 'data-method' => 'post'];
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', Url::to(['delete', 'id' => $model->c_id]), $options);
                            }
                        },
                                'send' => function ($url, $model, $key) {
                            if ($model->c_is_send == MarketCard::STATUS_NO) {
                                $options = ['title' => '设置发放', 'aria-label' => '设置发放', 'data-pjax' => '1', 'data-confirm' => '您确定要设置卡号状态已发放吗？', 'data-method' => 'post'];
                                return Html::a('<i class="glyphicon glyphicon-bullhorn"></i>', Url::to(['send', 'id' => $model->c_id]), $options);
                            }
                        },
                                'used' => function ($url, $model, $key) {
                            if ($model->c_is_used == MarketCard::STATUS_NO && $model->c_is_send == MarketCard::STATUS_YES) {
                                $options = ['title' => '设置使用', 'aria-label' => '设置使用', 'data-pjax' => '1', 'data-confirm' => '您确定要设置卡号状态已使用吗？', 'data-method' => 'post'];
                                return Html::a('<i class="glyphicon glyphicon-ban-circle"></i>', Url::to(['used', 'id' => $model->c_id]), $options);
                            }
                        },
                            ],
                            'visibleButtons' => [
                                'used' => CheckRule::checkRole('market-card/close'),
                                'send' => CheckRule::checkRole('market-card/send'),
                                'delete' => CheckRule::checkRole('market-card/delete')
                            ],
                            'footerOptions' => ['class' => 'hide'],
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
                $('.jquery-confirm').click(function () {
                    var keys = $('#grid').yiiGridView('getSelectedRows');
                    jqueryConfirm($(this), {id:keys.join(',')});
                });
            });
EOT;
        backend\assets\AppAsset::addScript($js);
        