<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use backend\models\AdminOperationLog;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '管理员操作记录列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['AdminOperationLogSearch']['pagesize']) ? $get['AdminOperationLogSearch']['pagesize'] : '';
$keyword = isset($get['AdminOperationLogSearch']['keyword']) ? trim($get['AdminOperationLogSearch']['keyword']) : '';
$status = isset($get['AdminOperationLogSearch']['status']) ? $get['AdminOperationLogSearch']['status'] : '';
$type = isset($get['AdminOperationLogSearch']['type']) ? $get['AdminOperationLogSearch']['type'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'type')->dropDownList(AdminOperationLog::getType(), ['prompt' => '选择类型', 'value' => $type]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Util::getStatusText(), ['prompt' => '选择状态', 'value' => $status]) ?>
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
                    'attribute' => 'c_route',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_route) : $model->c_route;
                    }
                ],
                [
                    'label' => '路由名称',
                    'attribute' => 'c_route',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->adminRoute->c_title) ? $model->adminRoute->c_title : '--';
                    }
                ],
                [
                    'attribute' => 'c_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return AdminOperationLog::getType($model->c_type);
                    },
                ],
                'c_object_id',
                [
                    'attribute' => 'c_admin_name',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_admin_name) : $model->c_admin_name;
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
                    'attribute' => 'c_data_before',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->c_data_before ? '<span title="' . htmlentities(print_r(json_decode($model->c_data_before, true), true)) . '">移动鼠标查看</span>' : '--';
                    }
                ],
                [
                    'attribute' => 'c_data_add',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->c_data_add ? '<span title="' . htmlentities(print_r(json_decode($model->c_data_add, true), true)) . '">移动鼠标查看</span>' : '--';
                    }
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ]
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>