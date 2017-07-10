<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\UserAcountLog;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '资金操作记录';
$get = Yii::$app->request->get();
$pagesize = isset($get['UserAcountLogSearch']['pagesize']) ? $get['UserAcountLogSearch']['pagesize'] : '';
$keyword = isset($get['UserAcountLogSearch']['keyword']) ? trim($get['UserAcountLogSearch']['keyword']) : '';
$type = isset($get['UserAcountLogSearch']['type']) ? $get['UserAcountLogSearch']['type'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'type')->dropDownList(UserAcountLog::getType(), ['prompt' => '选择日志类型', 'value' => $type]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('user/amount')) { ?>
            <div class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', Url::to(['user/amount']), ['class' => 'btn btn-success']) ?>
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
                    'label' => '用户名',
                    'attribute' => 'c_user_name',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->user->c_user_name) : $model->user->c_user_name;
                    }
                ],
                [
                    'label' => '手机号',
                    'attribute' => 'c_mobile',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->user->c_mobile) : $model->user->c_mobile;
                    }
                ],
                [
                    'label' => '邮箱',
                    'attribute' => 'c_email',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->user->c_email) : $model->user->c_email;
                    }
                ],
                [
                    'attribute' => 'c_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return '<label class="label ' . ($model->c_type == 1 ? 'bg-green' : 'bg-red') . '">' . UserAcountLog::getType($model->c_type) . '</label>';
                    }
                ],
                'c_amount_old', 'c_amount', 'c_amount_new', 'c_frozen_amount_old', 'c_frozen_amount', 'c_frozen_amount_new', 'c_admin_name',
                [
                    'attribute' => 'c_note_type',
                    'format' => 'raw',
                    'value' => function($model) {
                        return UserAcountLog::getNote($model->c_note_type) . ($model->c_order_no ? '<br>订单号：' . $model->c_order_no : '');
                    },
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