<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\NotityTemplate;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '消息模板列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['NotityTemplateSearch']['pagesize']) ? $get['NotityTemplateSearch']['pagesize'] : '';
$keyword = isset($get['NotityTemplateSearch']['keyword']) ? trim($get['NotityTemplateSearch']['keyword']) : '';
$status = isset($get['NotityTemplateSearch']['status']) ? $get['NotityTemplateSearch']['status'] : '';
$type = isset($get['NotityTemplateSearch']['type']) ? $get['NotityTemplateSearch']['type'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Util::getStatusText(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'type')->dropDownList(NotityTemplate::getType(), ['prompt' => '选择消息类型', 'value' => $type]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('notity-template/create')) { ?>
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
                    'attribute' => 'c_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return NotityTemplate::getType($model->c_type);
                    },
                ],
                [
                    'attribute' => 'c_email_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_email_status);
                    },
                ],
                [
                    'attribute' => 'c_sms_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_sms_status);
                    },
                ],
                [
                    'attribute' => 'c_web_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_web_status);
                    },
                ],
                [
                    'attribute' => 'c_app_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_app_status);
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
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{update}</span><span class="pr20">{delete}</span>',
                    'visibleButtons' => [
                        'update' => CheckRule::checkRole('notity-template/update'),
                        'delete' => CheckRule::checkRole('notity-template/delete')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>