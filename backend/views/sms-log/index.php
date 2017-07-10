<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\NotityTemplate;
use common\extensions\Util;
use backend\widgets\SearchForm;
use backend\widgets\GridView;

$this->title = '短信日志列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['SmsLogSearch']['pagesize']) ? $get['SmsLogSearch']['pagesize'] : '';
$keyword = isset($get['SmsLogSearch']['keyword']) ? trim($get['SmsLogSearch']['keyword']) : '';
$status = isset($get['SmsLogSearch']['status']) ? $get['SmsLogSearch']['status'] : '';
$type = isset($get['SmsLogSearch']['type']) ? $get['SmsLogSearch']['type'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(NotityTemplate::getSendStatus(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'type')->dropDownList(NotityTemplate::getType(), ['prompt' => '选择消息类型', 'value' => $type]) ?>
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
                    'attribute' => 'c_mobile',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_mobile) : $model->c_mobile;
                    }
                ],
                [
                    'attribute' => 'c_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return NotityTemplate::getType($model->c_type);
                    }
                ],
                'c_body', 'c_sms_model',
                [
                    'attribute' => 'c_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return NotityTemplate::getSendStatus($model->c_status);
                    },
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>