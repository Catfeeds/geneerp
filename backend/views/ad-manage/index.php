<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\AdManage;
use common\models\AdPosition;
use common\models\Upload;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '广告列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['AdManageSearch']['pagesize']) ? $get['AdManageSearch']['pagesize'] : '';
$keyword = isset($get['AdManageSearch']['keyword']) ? trim($get['AdManageSearch']['keyword']) : '';
$status = isset($get['AdManageSearch']['status']) ? $get['AdManageSearch']['status'] : '';
$type = isset($get['AdManageSearch']['type']) ? $get['AdManageSearch']['type'] : '';
$position_id = isset($get['AdManageSearch']['position_id']) ? $get['AdManageSearch']['position_id'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Util::getStatusText(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'type')->dropDownList(AdManage::getType(), ['prompt' => '选择类型', 'value' => $type]) ?>
            <?= $form->field($searchModel, 'position_id')->dropDownList(AdPosition::getKeyValueCache(), ['prompt' => '选择广告位', 'value' => $position_id]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('ad-manage/create')) { ?>
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
                    'attribute' => 'c_url',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_url) : $model->c_url;
                    }
                ],
                [
                    'attribute' => 'c_content',
                    'format' => ['image', ['height' => 50]],
                    'value' => function ($model) {
                if ($model->c_type == 2) {
                    Upload::getThumbOne($model->c_content, true);
                }
            }
                ],
                [
                    'attribute' => 'c_position_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->adPosition->c_title) ? $model->adPosition->c_title : '--';
                    },
                ],
                [
                    'attribute' => 'c_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return AdManage::getType($model->c_type);
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
                        'update' => CheckRule::checkRole('ad-manage/update'),
                        'delete' => CheckRule::checkRole('ad-manage/delete')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>