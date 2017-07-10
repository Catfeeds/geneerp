<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\User;
use common\models\UserGroup;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '用户列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['UserSearch']['pagesize']) ? $get['UserSearch']['pagesize'] : '';
$keyword = isset($get['UserSearch']['keyword']) ? trim($get['UserSearch']['keyword']) : '';
$status = isset($get['UserSearch']['status']) ? $get['UserSearch']['status'] : '';
$group_id = isset($get['UserSearch']['group_id']) ? $get['UserSearch']['group_id'] : '';
$create_type = isset($get['UserSearch']['create_type']) ? $get['UserSearch']['create_type'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Util::getStatusText(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'group_id')->dropDownList(UserGroup::getKeyValueCache(), ['prompt' => '选择用户组', 'value' => $group_id]) ?>
            <?= $form->field($searchModel, 'create_type')->dropDownList(User::getCreateType(), ['prompt' => '选择注册类型', 'value' => $create_type]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('user/create')) { ?>
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
                    'attribute' => 'c_user_name',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_user_name) : $model->c_user_name;
                    }
                ],
                [
                    'attribute' => 'c_mobile',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return User::getVerifyStatus($model->c_mobile_verify) . ($keyword ? Util::highlight($keyword, $model->c_mobile) : $model->c_mobile);
                    }
                ],
                [
                    'attribute' => 'c_email',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return User::getVerifyStatus($model->c_email_verify) . ($keyword ? Util::highlight($keyword, $model->c_email) : $model->c_email);
                    }
                ],
                [
                    'attribute' => 'c_group_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->userGroup->c_title) ? $model->userGroup->c_title : '--';
                    }
                ],
                [
                    'attribute' => 'c_create_type',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return User::getCreateType($model->c_create_type);
                    }
                ],
                [
                    'label' => '用户积分',
                    'attribute' => 'c_point',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->userAcount->c_point) ? $model->userAcount->c_point : '--';
                    },
                ],
                [
                    'label' => '用户经验值',
                    'attribute' => 'c_exp',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->userAcount->c_exp) ? $model->userAcount->c_exp : '--';
                    },
                ],
                [
                    'label' => '现金账户金额',
                    'attribute' => 'c_amount',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->userAcount->c_amount) ? $model->userAcount->c_amount : '--';
                    },
                ],
                [
                    'label' => '冻结账户金额',
                    'attribute' => 'c_frozen_amount',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->userAcount->c_frozen_amount) ? $model->userAcount->c_frozen_amount : '--';
                    },
                ],
                [
                    'attribute' => 'c_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_status);
                    },
                ],
                'c_login_total',
                [
                    'attribute' => 'c_reg_date',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{amount}</span><span class="pr20">{update}</span>',
                    'buttons' => [
                        'amount' => function ($url, $model, $key) {
                            $options = ['title' => '用户账户管理', 'aria-label' => '用户账户管理', 'data-pjax' => '0'];
                            return Html::a('<i class="glyphicon glyphicon-credit-card"></i>', Url::to(['amount', 'id' => $key]), $options);
                        },
                            ],
                            'visibleButtons' => [
                                'amount' => CheckRule::checkRole('user/amount'),
                                'update' => CheckRule::checkRole('user/update'),
                            ]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
    </div>
</div>