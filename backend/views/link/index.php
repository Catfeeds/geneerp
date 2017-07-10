<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Link;
use common\models\Upload;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '链接列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['LinkSearch']['pagesize']) ? $get['LinkSearch']['pagesize'] : '';
$keyword = isset($get['LinkSearch']['keyword']) ? trim($get['LinkSearch']['keyword']) : '';
$status = isset($get['LinkSearch']['status']) ? $get['LinkSearch']['status'] : '';
$type = isset($get['LinkSearch']['type']) ? $get['LinkSearch']['type'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Link::getStatus(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'type')->dropDownList(Link::getType(), ['prompt' => '选择类型', 'value' => $type]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('link/create')) { ?>
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
                    'attribute' => 'c_picture',
                    'format' => ['image', ['height' => 50]],
                    'value' => function ($model) {
                return Upload::getThumbOne($model->c_picture, true);
            }
                ],
                [
                    'attribute' => 'c_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Link::getType($model->c_type);
                    },
                ],
                [
                    'attribute' => 'c_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Link::getStatus($model->c_status);
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
                        'update' => CheckRule::checkRole('link/update'),
                        'delete' => CheckRule::checkRole('link/delete')
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>